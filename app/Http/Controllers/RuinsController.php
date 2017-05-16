<?php

namespace App\Http\Controllers;

use App\Ruin;

class RuinsController extends Controller
{
    public function index()
    {
        return view('index', [
            'ruins' => Ruin::orderBy('name', 'asc')->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Ruin $ruin
     * @return Ruin
     * @internal param int $id
     */
    public function show(Ruin $ruin)
    {
        return view('show', [
            'ruin' => $ruin
        ]);
    }

    public function home()
    {
        return view('home');
    }
}
