<?php

namespace App\Http\Controllers;

use App\Models\Weight;
use Illuminate\Http\Request;

class WeightController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weights = Weight::orderBy('date', 'desc')->paginate(15);

        $old_weight = null;
        foreach ($weights as $current_weight) {
            if ($old_weight) {
                $old_weight->setAttribute('difference', $old_weight->weight - $current_weight->weight);
            }

            $old_weight = $current_weight;
        }

        return view('weight.index', ['weights' => $weights]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('weight.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'weight' => 'required|numeric|min:0',
        ]);

        if (Weight::where('date', $request->date)->exists()) {
            return redirect()->back()->with('warning', 'A for this date exists already.');
        }

        $weight = Weight::make($validatedData);

        auth()->user()->weights()->save($weight);

        return redirect()->route('weights.index')->with('success', 'The weight was successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function show(Weight $weight)
    {
        return view('weight.show', compact('weight'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function edit(Weight $weight)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weight $weight)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Weight  $weight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weight $weight)
    {
        $weight->delete();

        return redirect()->route('weights.index')->with('success', 'The weight was successfully deleted.');
    }
}
