<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

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
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {   
        $user = Auth::user();
        $users = DB::table('users')->get();
        $tweets = DB::table('tweets')->orderBy('updated_at','desc')->get();
        $fav = DB::table('tweet_fav')->get();
        return view('home',['user' => $user , 'users' => $users , 'tweets' => $tweets , 'favs' => $fav]);
    }
}