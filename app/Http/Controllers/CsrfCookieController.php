<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsrfCookieController extends Controller
{
    /**
     * Get the CSRF token cookie.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $cookieName = config('session.cookie');
        $cookieValue = $request->session()->token();

        return response()->json(['csrf_token' => $cookieValue])->withCookie($cookieName, $cookieValue);
    }
}
