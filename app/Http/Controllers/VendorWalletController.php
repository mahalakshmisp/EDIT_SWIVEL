<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendorWalletController extends Controller
{
    public function show()
    {
        $vendor = auth('vendor')->user();
        $videos = \App\Models\Video::where('vendor_id', $vendor->id)->with('purchases')->get();
        $wallet = 0;
        foreach ($videos as $video) {
            $wallet += $video->purchases->count() * ($video->price * 0.7);
        }
        return view('vendor.wallet', compact('vendor', 'wallet'));
    }
}
