<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Home';
        $totalrecords = Todo::where('user_id' , auth()->user()->id)->select('*')->count();
        $todos = Todo::where('user_id' , auth()->user()->id)->get();
        return view('pages.index' , compact( 'title' , 'totalrecords' , 'todos'));
    }
}
