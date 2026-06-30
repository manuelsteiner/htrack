<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Token;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $settings = $user->settings;
        $tokens = $user->tokens()->orderByDesc('created_at')->get();

        $connections = Token::query()
            ->where('user_id', $user->id)
            ->where('revoked', false)
            ->where(fn ($q) => $q->whereNull('expires_at')->orWhere('expires_at', '>', now()))
            ->with('client')
            ->get()
            ->filter(fn ($token) => $token->client && ! $token->client->revoked)
            ->groupBy('client_id')
            ->map(fn ($tokens) => (object) [
                'client' => $tokens->first()->client,
                'authorized_at' => $tokens->min('created_at'),
                'expires_at' => $tokens->max('expires_at'),
            ])
            ->sortByDesc('authorized_at')
            ->values();

        return view('settings.index', [
            'settings' => $settings,
            'tokens' => $tokens,
            'connections' => $connections,
            'plainTextToken' => session('plainTextToken'),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gender' => 'nullable|in:male,female',
            'birthday' => 'nullable|date|before:today',
            'height' => 'nullable|integer|min:1',
            'goal_weight' => 'nullable|numeric|min:0',
            'activity_factor' => 'nullable|numeric|min:1|max:2.5',
            'timezone' => 'nullable|timezone',
            'calorie_targets.monday' => 'required|integer|min:0',
            'calorie_targets.tuesday' => 'required|integer|min:0',
            'calorie_targets.wednesday' => 'required|integer|min:0',
            'calorie_targets.thursday' => 'required|integer|min:0',
            'calorie_targets.friday' => 'required|integer|min:0',
            'calorie_targets.saturday' => 'required|integer|min:0',
            'calorie_targets.sunday' => 'required|integer|min:0',
            'protein_target' => 'nullable|integer|min:0',
        ]);

        $settings = auth()->user()->settings;
        $settings->fill($request->only([
            'gender', 'birthday', 'height', 'goal_weight', 'activity_factor', 'timezone', 'calorie_targets', 'protein_target',
        ]));
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings saved.');
    }
}
