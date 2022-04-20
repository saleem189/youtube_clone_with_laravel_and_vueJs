<?php

namespace App\Http\Controllers;

use App\Jobs\Videos\ConvertForStreaming;
use App\Jobs\Videos\CreateVideoThumbnail;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * using Route Model Binding to Get the Channel and Upload
     * videos to that Channel
     */
    public function index(Channel $channel)
    {
        /**
         * passing channel oject to the view 
         */
        
        return view('channel.upload',
        [
            'channel' => $channel,
        ]
    );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Channel $channel)
    {
        /**
         * storing video by relation
         */
    //    dd(request()->video->store("channels/{$channel->id}",['disk' => 'local'])); 

//    dd(request()->video);
       $video = $channel->videos()->create([
            'title' => request()->title,
            /**
             *  now we need to pass and the path is to be the uploaded path for the Video
             *  so here we request Video Model and call the store method to pass the path
             * to the video.. so call the channels and the channel id to store the video for a specific
             * channel in a seperate folder and put the videos in that folder
             * now we are simpily creating a new video and uploading the video to chanel slash chanel->id Folder 
             * and saving the path into database
             *  
             */
            'path' => request()->video->store("channels/{$channel->id}")
            
        ]);
        /**
         * here we are passing video to CreateVideoThumbnail Job to convert it into Thumbnails
         */
        $this->dispatch(new CreateVideoThumbnail($video));
        /**
         * now calling the Queue job we made for converting the video
         * ConvertForStreaming in Jobs and passing the video to it
         * we will recieve this video int the ConvertForStreaming class of queue
         * every time the video is uploaded the video is save to database and to the variable
         * and dispach to the que to converting
         */
        $this->dispatch(new ConvertForStreaming($video));
        return $video;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('show',compact($video));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
  
    }
}
