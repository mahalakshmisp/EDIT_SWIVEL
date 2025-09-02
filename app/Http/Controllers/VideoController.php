<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VideoController extends Controller
{
    public function aari()
    {
        return view('video.aari');
    }
    public function abacus()
    {
        return view('video.abacus');
    }
    public function baking()
    {
        return view('video.baking');
    }
    public function beautician()
    {
        return view('video.beautician');
    }
    public function car()
    {
        return view('video.car');
    }
    public function carrer()
    {
        return view('video.carrer');
    }
    public function dm()
    {
        return view('video.dm');
    }
    public function exam()
    {
        return view('video.exam');
    }
    public function fashion()
    {
        return view('video.fashion');
    }
    public function fittness()
    {
        return view('video.fitness');
    }
    public function mobile()
    {
        return view('video.mobile');
    }
    public function music()
    {
        return view('video.music');
    }
    public function photo()
    {
        return view('video.photo');
    }
    public function school()
    {
        return view('video.school');
    }
    public function tailoring()
    {
        return view('video.tailoring');
    }
    public function web()
    {
        return view('video.web');
    }

    public function sixth()
    {
        return view('classes.sixth');
    }

    public function seventh()
    {
        return view('classes.seventh');
    }
    public function eight()
    {
        return view('classes.eight');
    }

    public function ninenth()
    {
        return view('classes.ninenth');
    }
    public function tenth()
    {
        return view('classes.tenth');
    }
    public function eleventh()
    {
        return view('classes.eleventh');
    }
     public function twelth()
    {
        return view('classes.twelth');
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('videos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'videos.*' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime|max:204800',
        ]);

        $files = array_filter($request->file('videos', []));
        if (count($files) == 0) {
            return redirect()->back()->with('error', 'Please select at least one video to upload.');
        }

        $courseName = $request->course_name ?: $request->new_course_name;
        $authorName = $request->author_name ?: $request->new_author_name;
        $authorDescription = $request->author_description ?? null;
        $courseDescription = $request->course_description ?? null;
        $category = Category::findOrFail($request->category_id);
        $subjectName = $category->name;

        foreach ($files as $videoFile) {
            // sanitize names for filesystem
            $safeSubject = preg_replace('/[^A-Za-z0-9 _-]/', '', $subjectName);
            $safeCourse = preg_replace('/[^A-Za-z0-9 _-]/', '', $courseName);
            $safeAuthor = preg_replace('/[^A-Za-z0-9 _-]/', '', $authorName);

            // Ensure directory is under 'public/' for local storage
            $directory = "{$safeSubject}/{$safeCourse}/{$safeAuthor}";
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $filename = preg_replace('/[^A-Za-z0-9._-]/', '_', $videoFile->getClientOriginalName());
            $path = Storage::disk('public')->putFileAs($directory, $videoFile, $filename);
            // $path will be relative to storage/app/public
            // Save DB path as 'public/' . $path for consistency
            $dbPath = 'public/' . ltrim($path, '/');

            // save record
            $video = new Video();
            $video->course_name = $courseName;
            $video->author_name = $authorName;
            $video->author_description = $authorDescription;
            $video->course_description = $courseDescription;
            $video->category_id = $category->id;
            $video->video_path = $dbPath;
            $video->price = $request->price;
            if (auth('vendor')->check()) {
                $video->vendor_id = auth('vendor')->id();
            }
            $video->save();
        }

        return redirect()->route('courses.show', $courseName)->with('success', 'Videos uploaded successfully!');
    }

    public function stream($id)
    {
        $pathParam = request()->query('path');
        $resolvedPath = null;

        $tryPaths = [];

        if ($pathParam) {
            $decoded = rawurldecode($pathParam);
            $decoded = str_replace('+', ' ', $decoded);
            // candidate as-is
            $tryPaths[] = storage_path('app/' . $decoded);
            // if it already starts with public/, try without public/
            if (str_starts_with($decoded, 'public/')) {
                $tryPaths[] = storage_path('app/' . substr($decoded, 7));
            }
            // try with public/ prefix (common)
            if (!str_starts_with($decoded, 'public/')) {
                $tryPaths[] = storage_path('app/public/' . ltrim($decoded, '/'));
            }
            // try storage path variations
            $tryPaths[] = storage_path('app/storage/' . ltrim($decoded, '/'));
        } else {
            $video = \App\Models\Video::find($id);
            if ($video) {
                $dbPath = $video->video_path;
                // handle dbPath that might start with 'storage/app/' or '/storage/app/'
                if (str_starts_with($dbPath, '/storage/app/')) {
                    $relative = substr($dbPath, strlen('/storage/app/'));
                    $tryPaths[] = storage_path('app/' . ltrim($relative, '/'));
                } elseif (str_starts_with($dbPath, 'storage/app/')) {
                    $relative = substr($dbPath, strlen('storage/app/'));
                    $tryPaths[] = storage_path('app/' . ltrim($relative, '/'));
                }
                $tryPaths[] = storage_path('app/' . $dbPath);
                if (str_starts_with($dbPath, 'public/')) {
                    $tryPaths[] = storage_path('app/' . substr($dbPath, 7));
                }
                $tryPaths[] = storage_path('app/public/' . ltrim($dbPath, '/'));
            }
        }

        // Normalize and check candidates
        $storageRoot = realpath(storage_path('app')) ?: storage_path('app');
        foreach ($tryPaths as $p) {
            if (! $p) continue;
            $real = realpath($p);
            if ($real && str_starts_with($real, $storageRoot) && file_exists($real)) {
                $resolvedPath = $real;
                break;
            }
        }

        if (! $resolvedPath) {
            // Log attempts for debugging
            try { \Log::warning('Video stream: file not found, attempted paths: ' . join(', ', $tryPaths)); } catch (\Throwable $e) {}
            abort(404);
        }

        $size = filesize($resolvedPath);
        $mime = mime_content_type($resolvedPath) ?: 'video/mp4';
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
        ];

        $range = request()->header('Range');
        if ($range) {
            [$unit, $rangeValue] = explode('=', $range, 2) + [null, null];
            if ($unit !== 'bytes') {
                return response('', 416);
            }
            $ranges = explode('-', $rangeValue);
            $start = ($ranges[0] !== '') ? intval($ranges[0]) : 0;
            $end = (isset($ranges[1]) && $ranges[1] !== '') ? intval($ranges[1]) : $size - 1;
            if ($end >= $size) $end = $size - 1;
            if ($start > $end || $start >= $size) {
                return response('', 416);
            }
            $length = $end - $start + 1;
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
            $headers['Content-Length'] = $length;

            $stream = function () use ($resolvedPath, $start, $length) {
                $fp = fopen($resolvedPath, 'rb');
                if ($fp === false) return;
                fseek($fp, $start);
                $buffer = 1024 * 8;
                $bytesRemaining = $length;
                while ($bytesRemaining > 0 && !feof($fp)) {
                    $read = ($bytesRemaining > $buffer) ? $buffer : $bytesRemaining;
                    echo fread($fp, $read);
                    flush();
                    $bytesRemaining -= $read;
                }
                fclose($fp);
            };

            return response()->stream($stream, 206, $headers);
        }

        $headers['Content-Length'] = $size;
        $stream = function () use ($resolvedPath) {
            $fp = fopen($resolvedPath, 'rb');
            if ($fp === false) return;
            while (!feof($fp)) {
                echo fread($fp, 1024 * 8);
                flush();
            }
            fclose($fp);
        };
        return response()->stream($stream, 200, $headers);
    }
}
