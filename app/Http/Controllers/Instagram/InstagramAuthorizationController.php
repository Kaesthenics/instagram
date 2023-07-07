<?php

namespace App\Http\Controllers\Instagram;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class InstagramAuthorizationController extends Controller
{

    public function show(): RedirectResponse
    {
        $clientId = env('INSTAGRAM_CLIENT_ID');
        $urlRedirect = env('INSTAGRAM_REDIRECT_URI');
        $scope = 'user_profile,user_media';
        $responseType = 'code';
        return redirect("https://api.instagram.com/oauth/authorize?client_id=$clientId&redirect_uri=$urlRedirect&scope=$scope&response_type=$responseType");
    }
}
