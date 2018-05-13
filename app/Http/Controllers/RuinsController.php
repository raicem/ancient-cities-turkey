<?php

namespace App\Http\Controllers;

use App\Ruin;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\App;

class RuinsController extends Controller
{
    public function sitemap()
    {
        return view('sitemap.index', [
            'ruins' => Ruin::all()
        ]);
    }

    public function index($locale = 'tr')
    {
        App::setLocale($locale);

        return view('ruins.index');
    }

    public function show($locale = 'tr', Ruin $ruin)
    {
        App::setLocale($locale);

        $ruin = $ruin->asTurkish();

        if ($locale === 'en') {
            $ruin = $ruin->asEnglish();
        }

        return view('ruins.show', compact('ruin'));
    }
}
