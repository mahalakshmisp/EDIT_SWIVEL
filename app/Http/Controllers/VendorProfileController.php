<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorUpload;

class VendorProfileController extends Controller
{
    public function show()
    {
        $vendor = auth('vendor')->user();
        $videos = \App\Models\Video::where('vendor_id', $vendor->id)->with(['subscriptions.user', 'purchases.user'])->get();
        $wallet = 0;
        foreach ($videos as $video) {
            $wallet += $video->purchases->count() * ($video->price * 0.7);
        }
        return view('vendor.profile', compact('vendor', 'videos', 'wallet'));
    }

    public function uploadForm()
    {
        return view('vendor.upload_form');
    }

    public function uploadSubmit(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
        $vendor = Auth::guard('vendor')->user();
        VendorUpload::create([
            'vendor_id' => $vendor->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return redirect()->route('vendor.profile')->with('success', 'Upload successful!');
    }
}
