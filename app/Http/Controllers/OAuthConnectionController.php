<?php

namespace App\Http\Controllers;

use Laravel\Passport\Client;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;

class OAuthConnectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function destroy(string $clientId)
    {
        $userId = auth()->id();

        $tokenIds = Token::where('user_id', $userId)
            ->where('client_id', $clientId)
            ->pluck('id');

        if ($tokenIds->isNotEmpty()) {
            RefreshToken::whereIn('access_token_id', $tokenIds)->update(['revoked' => true]);
            Token::whereIn('id', $tokenIds)->update(['revoked' => true]);
        }

        Client::where('id', $clientId)->update(['revoked' => true]);

        return redirect()->route('settings.index')->with('success', 'Connection revoked.');
    }
}
