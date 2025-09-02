<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
    public function showCategory(Category $category)
    {
        $courses = Video::where('category_id', $category->id)->groupBy('course_name')->get();
        return view('courses.category', compact('category', 'courses'));
    }

    public function showCourse($course)
    {
        $videos = Video::where('course_name', $course)->get();
        $subscribed = false;
        if (Auth::check()) {
            $normalized = Str::lower(trim($course));
            $subscribed = DB::table('subscriptions')
                ->where('user_id', Auth::id())
                ->whereRaw('LOWER(TRIM(course_name)) = ?', [$normalized])
                ->exists();
        }
        return view('courses.show', compact('course', 'videos', 'subscribed'));
    }

    public function subscribe(Request $request, $course)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login or signup to subscribe.');
        }

        $userId = Auth::id();
        $normalized = Str::lower(trim($course));

        $exists = DB::table('subscriptions')
            ->where('user_id', $userId)
            ->whereRaw('LOWER(TRIM(course_name)) = ?', [$normalized])
            ->exists();

        if (! $exists) {
            $createData = [
                'user_id' => $userId,
                'course_name' => $course,
            ];

            if (Schema::hasColumn('subscriptions', 'payment_method') && $request->filled('payment_method')) {
                $createData['payment_method'] = $request->input('payment_method');
            }

            Subscription::create($createData);
        }

        return redirect()->route('courses.show', $course)->with('success', 'Subscription active. You can now view videos.');
    }

    public function purchasePage($course)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login or signup to subscribe.');
        }
        $videos = Video::where('course_name', $course)->get();
        return view('courses.purchase', compact('course', 'videos'));
    }

   public function showSubject($subject)
{
    $category = Category::where('name', $subject)->first();

    // If category exists, fetch all courses related to it
    $courses = Video::where('category_id', $category ? $category->id : 0)
        ->get();  // 👈 fetch all columns instead of only course_name

    return view('courses.subject', compact('subject', 'courses'));
}


    public function showAuthor($course)
    {
        $author = Video::where('course_name', $course)->first();
        return view('authors.show', compact('course', 'author'));
    }

    public function purchase(Request $request, $course)
    {
        $video = \App\Models\Video::findOrFail($course);
        if (auth()->check()) {
            \App\Models\Purchase::create([
                'video_id' => $video->id,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('courses.show', $course)->with('success', 'Purchase successful. You can now access the video.');
    }
}
