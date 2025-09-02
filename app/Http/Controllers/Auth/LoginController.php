<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        session(['url.intended' => url()->previous()]);

        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        // ...existing code...
    }

    /**
     * Get the post registration / login redirect path.
     *
     * @return string
     */
    protected function redirectTo()
    {
        return '/';
    }

    /**
     * Get the post registration / login redirect path.
     *
     * @return string
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended('/');
    }
}