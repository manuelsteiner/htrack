<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiTokenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('personal_access_tokens', 'name')->where(function ($query) {
                    $query->where('tokenable_type', auth()->user()->getMorphClass())
                        ->where('tokenable_id', auth()->id());
                }),
            ],
        ]);

        $token = auth()->user()->createToken($validated['name']);

        return redirect()->route('settings.index')
            ->with('plainTextToken', $token->plainTextToken)
            ->with('success', 'API token created. Copy it now — it will not be shown again.');
    }

    public function refresh(Request $request, $id)
    {
        $token = auth()->user()->tokens()->findOrFail($id);
        $name = $token->name;
        $token->delete();

        $newToken = auth()->user()->createToken($name);

        return redirect()->route('settings.index')
            ->with('plainTextToken', $newToken->plainTextToken)
            ->with('success', 'API token refreshed. Copy the new token now — it will not be shown again.');
    }

    public function destroy($id)
    {
        $token = auth()->user()->tokens()->findOrFail($id);
        $token->delete();

        return redirect()->route('settings.index')->with('success', 'API token deleted.');
    }
}
