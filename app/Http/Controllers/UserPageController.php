<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use Intervention\Image\ImageManagerStatic as Image;

class UserPageController extends Controller
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
    public function getIndex(Request $request,$id)
    {   
        $user = DB::table('users')->where('id',$id)->first();
        $tweets = DB::table('tweets')->where('user_id',$id)->orderBy('updated_at','desc')->get();
        $fav = DB::table('tweet_fav')->where('user_id',$id)->get();
        return view('userpage',['user' => $user , 'tweets' => $tweets , 'favs' => $fav]);
    }

    public function userTweet(Request $request)
    {
        $this->validate($request, [
            'image_file' => [
                'file',
                'image',
            ]
        ]);

        date_default_timezone_set("Asia/Tokyo"); // タイムゾーンを日本に設定
        $user = Auth::user();
        $now = date('Y/m/d H:i:s');

        if ($request->hasfile('image_file')){
            $filename = $request->file('image_file')->getClientOriginalName();

            //$file = Image::make($request->file('image_file'))->resize(100, null, function ($constraint) { $constraint->aspectRatio(); })->store('public/image');
            //$filename = substr($file,13);

            $tweet_id = DB::table('tweets')->insertGetId([
                            'user_id' => $user->id,
                            'tweet' => $request->tweet,
                            'image' => $filename,
                            'updated_at' => $now
                        ]);

            $image = Image::make($request->file('image_file')->getRealPath());
            File::exists(public_path() . '/images/' . $user->id) or File::makeDirectory(public_path() . '/images/' . $user->id,0777,true);
            $image->resize(650, null, function ($constraint) {$constraint->aspectRatio();})
                  ->save(public_path() . '/images/' . $user->id . '/' . $tweet_id . '_' . $filename);

            return redirect()->back();
        } else {
            DB::table('tweets')->insert([
                'user_id' => $user->id,
                'tweet' => $request->tweet,
                'updated_at' => $now
            ]);
            return redirect()->back();
        }


    }

    public function deleteTweet(Request $request)
    {
        $user = Auth::user();

        $tweet = DB::table('tweets')->where('id',$request->tweet_id)->first();
        File::delete(public_path() . '/images/' . $user->id . '/' . $request->tweet_id . '_' . $tweet->image);
        DB::table('tweets')->where('id',$request->tweet_id)->delete();
        DB::table('tweet_fav')->where('id',$request->tweet_id)->delete();

        return redirect()->back();
    }


    public function tweetFav(Request $request)
    {
        $user = Auth::user();

        DB::table('tweet_fav')->insert([
            'user_id' => $user->id,
            'tweet_id' => $request->tweet_id
        ]);

        return redirect()->back();
    }

    public function tweetFavReset(Request $request)
    {
        $user = Auth::user();

        DB::table('tweet_fav')->where('user_id',$user->id)->where('tweet_id',$request->tweet_id)->delete();

        return redirect()->back();
    }
}
