<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function purchases()
    {
        $user = auth()->user();
        $purchases = \App\Models\Purchase::where('user_id', $user->id)->with('video')->get();
        return view('user.purchases', compact('user', 'purchases'));
    }

    public function profile()
    {
        $user = auth()->user();
        $purchases = \App\Models\Purchase::where('user_id', $user->id)->with('video')->get();
        return view('user.profile', compact('user', 'purchases'));
    }
}
