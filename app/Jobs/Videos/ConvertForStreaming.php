<?php

namespace App\Jobs\Videos;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFMpeg\Format\Video\X264;

class ConvertForStreaming implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $video; //defing video property to access and save the video to this variable 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /**
         * we use FFMpeg\Format\Video\X264; 
         * and use FFMpeg for converting videos here 
         * before using these libraries we were just
         * returning or printing String like echo 'Converted';
         * and here we are creating a loop between low, medium and high quality videos according to client internet
         * these videos will be converted here before uploaded to server  
         */
        $low = (new X264('aac'))->setKiloBitrate(100); //equivalent to 360p
        $medium = (new X264('aac'))->setKiloBitrate(250); //equivalent to 480p
        $high = (new X264('aac'))->setKiloBitrate(500); //equivalent to 720p
        /**
         * now we are going to use FFMpeg to give path of videos like take videos from local
         * 
         */
        FFMpeg::fromDisk('local')
        ->open($this->video->path)
        ->exportForHLS()
        ->onProgress(function ($percentage) {
           $this->video->update([
               'percentage' => $percentage
            
           ]);
        })
        ->addFormat($low)
        
        ->addFormat($medium)
        ->addFormat($high)
       /**
        * we will use below URL later in Video player Source
        */
        ->save("public/videos/{$this->video->id}.m3u8");
        // echo('this line');
      
    }
}
