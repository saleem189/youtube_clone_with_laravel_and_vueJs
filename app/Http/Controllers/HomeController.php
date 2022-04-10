<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Channel;

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
        
        /**
         * here making $video and $channel a collection object or array and all operation which are performed
         * on Model Collections can also be perform on $video and $channel as they are converted into collections
         */
        $videos = collect();
        $channels = collect();

        $query = request()->search;
        if ($query){
            /**
             * paginate(4,['*'], 'video_page'); are for the chanels and video if channel is page one then it should not effect video pagination
             * thesw lines will handle pagination seperatly fro channels and videos
             */
            $channels = Channel::where('name','LIKE',"%{$query}%")->orWhere('description','LIKE',"%{$query}%")->paginate(4,['*'], 'video_page');
            $videos = Video::where('title','LIKE',"%{$query}%")->orWhere('description','LIKE',"%{$query}%")->paginate(5,['*'], 'channel_page');
        }

        
        return view('home')->with([
            'videos' => $videos,
            'channels' => $channels
        ]);
    }
}
