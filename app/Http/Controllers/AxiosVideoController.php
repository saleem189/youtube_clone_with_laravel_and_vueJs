<?php

namespace App\Http\Controllers;

use App\Http\Requests\Video\UpdateVideolRequest;
use App\Models\Video;
use Illuminate\Http\Request;

class AxiosVideoController extends Controller
{
    public function show(Video $video){
        
        /**
         * it is a laravel method that check if the request is JSON or not
         * 
         */
               if(request()->wantsJson()){
                return $video;
            }

            // dd($video->comments->first()->replies);
            // else part
            
            return view('video.video',compact('video'));
        
    }

    public function updateViews(Video $video){

        /**
         * Eloquent mechanism isn’t limited to just create/update/delete functions – that’s why it’s awesome. One of those helpers come to rescue when you need to increment a column, basically run update X set Y=Y+1 where id = Z – apparently, there’s no need to run update() function for that.
         * What if I told you it could be done in one line? Let’s meet a function called increment():
         *Customer::find($customer_id)->increment('loyalty_points');
         *That’s it – it will actually run update column + 1 under the hood.
         *And not only that, you can specify a second parameter to this function: the amount of incrementing. The default is 1, but it can be any other number:
         *Customer::find($customer_id)->increment('loyalty_points', 50);
         * 
         * 
         */

        $video->increment('views');
        return response()->json([]);
    }

    public function update(UpdateVideolRequest $request, Video $video){
        $video->update($request->only(['title','description']));
        return redirect()->back();
    }
}
