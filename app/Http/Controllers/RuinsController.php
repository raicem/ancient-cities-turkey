<?php

namespace App\Http\Controllers;

use App\Ruin;

class RuinsController extends Controller
{
    public function index()
    {
        return view('index', [
            'ruins' => Ruin::all()
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
            'ruin' => $ruin->load('links')
        ]);
    }

    public function home()
    {
        return view('home');
    }
}
