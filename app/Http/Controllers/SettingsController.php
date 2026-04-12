<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = auth()->user()->settings;

        return view('settings.index', ['settings' => $settings]);
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
        ]);

        $settings = auth()->user()->settings;
        $settings->fill($request->only([
            'gender', 'birthday', 'height', 'goal_weight', 'activity_factor', 'timezone', 'calorie_targets',
        ]));
        $settings->save();

        return redirect()->route('settings.index')->with('success', 'Settings saved.');
    }
}
