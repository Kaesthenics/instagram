<?php

namespace App\Http\Controllers\Instagram;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;

class InstagramAccessTokenController extends Controller
{
    public function show(Request $request)
    {
        $codeAuthorizationInstagram = $request->query('code');
        $clientId = env('INSTAGRAM_CLIENT_ID');
        $clientSecret = env('INSTAGRAM_CLIENT_SECRET');
        $urlRedirect = env('INSTAGRAM_REDIRECT_URI');

            $response = Http::asForm()->post('https://api.instagram.com/oauth/access_token', [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $urlRedirect,
                'code' => $codeAuthorizationInstagram,
            ]);

            $statusResponse = $response->status();
            $bodyResponse = json_decode($response->body(), true);

            if($statusResponse !== 200) {
                return redirect('/');
            }

        $token = $bodyResponse['access_token'];
        $userId = $bodyResponse['user_id'];

        $userInfo = Http::get("https://graph.instagram.com/$userId",
            [
                'access_token' => $token,
//                'fields' => 'id,username',
            ]);
        dd($token);
        return response()->json($userInfo);
    }
}
