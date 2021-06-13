<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;

class ChangeProfileController extends Controller
{

    public $redirectTo = '/changeprofile';


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'number' => 'required|numeric|digits:8',
            'email' => 'required|string|email|max:255',
            'intro' => 'max:255',
            'first_word' => 'max:100',
            'second_word' => 'max:100',
            'third_word' => 'max:100'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex()
    {
        $user = Auth::user();
        return view('changeprofile',['user' => $user]);
    }

    public function changeProfile(Request $request)
    {
        $user = Auth::user();

        $this->validator($request->all())->validate();

        // ユーザ情報が変更されていない場合
        if(strcmp($user->name,$request->name) == 0 &&
            $user->number == $request->number &&
            strcmp($user->email,$request->email) == 0 &&
            strcmp($user->intro,$request->intro) == 0 && 
            strcmp($user->first_word,$request->first_word) == 0 && 
            strcmp($user->second_word,$request->second_word) == 0 && 
            strcmp($user->third_word,$request->third_word) == 0 )
        {

            return redirect($this->redirectTo)->with('danger','ユーザ情報が変更されていません。');

        } else {

            $name = DB::table('users')->where('number',$request->number)->exists();


            if($name && $user->number != $request->number) {
                return redirect($this->redirectTo)->with('danger','すでにこの学籍番号は登録されています。');
            }

            DB::table('users')->where('id',$user->id)
            ->update([
                'name' => $request->name,
                'number' => $request->number,
                'email' => $request->email,
                'intro' => $request->intro,
                'first_word' => $request->first_word,
                'second_word' => $request->second_word,
                'third_word' => $request->third_word
            ]);

            return redirect($this->redirectTo)->with('message','ユーザー情報を変更しました。');
        }
    }

    public function deleteUser()
    {
        $user = Auth::user();

        DB::table('users')->where('id',$user->id)->delete();
        $tweets = DB::table('tweets')->get();
        foreach ($tweets as $tweet) {
            DB::table('tweet_fav')->where('tweet_id',$tweet->id)->delete();
        }
        DB::table('tweets')->where('user_id',$user->id)->delete();
        DB::table('tweet_fav')->where('user_id',$user->id)->delete();

        Auth::logout();

        return redirect('/login')->with('message','ユーザを削除しました。');
    }
}
