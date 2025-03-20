<?php

namespace App\Http\Controllers\Web; // <-- Updated namespace

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // Ensures only authenticated users access home
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $isAuthenticated = Auth::check();
        return view('home', ['isAuthenticated' => $isAuthenticated]); // Pass authentication status to the view
    }
}
