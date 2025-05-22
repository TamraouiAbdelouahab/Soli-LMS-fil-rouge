<?php

namespace Modules\Core\App\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Core\App\Controllers\BaseController;
use Modules\Core\App\Requests\Auth\LoginRequest;
// use Symfony\Component\HttpFoundation\Response;

class AuthenticatedSessionController extends BaseController
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Core::Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return Inertia::location(route('home'));
    }
}
