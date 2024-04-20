<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainMenuImage;
use App\Models\Promotion;
use App\Models\Zone;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::orderBy('position', 'asc')->get();
        $zones->load('tables');
        return Inertia::render('NewHome/Index', ['zones' => $zones]);
    }


    public function store(Request $request)
    {
        //
    }
}
