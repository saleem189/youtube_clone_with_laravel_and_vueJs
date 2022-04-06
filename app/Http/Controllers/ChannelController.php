<?php

namespace App\Http\Controllers;

use App\Http\Requests\Channels\UpdateChannelRequest;
use App\Models\Channel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChannelController extends Controller
{



    /**
     * here we will use middleware for Auntacation of user before performing
     * any updates in Channel
     * so here we are going to run it on only update mathod
     * only the user which id match with $channel->user_id 
     * can update the channel.. in simlpe words only the owner of channel
     * can update its channel 
     */

    public function __construct(){
        $this->middleware(['auth'])->only('update');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     * 
     * due to Resource Controller it will use Laravel route model binding
     * in the Web.php Routes Resource Route is Defined 
     * 
     */
    public function show(Channel $channel)
    {
        return view('channel.show',compact('channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        //
    }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'alpha', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'country' => ['required'],
    //         'state' => ['required'],
    //         'city' => ['required'],
    //     ]);
    // }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChannelRequest $request, Channel $channel)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'image' => 'image',
        //     'description' => 'required|max:1000'
        //     ]);
      
      
       
        
        $this->authorize('update', $channel); // policy for only owner can edit its channel information
        

            /**
             * use of Spatie Media Library here for image
             * for Validiation first we have to make custom Request
             * 
             * public function update(Request $request, Channel $channel) this was the default Request before changing to custom request 
             * 
             * the request used in the above line will be change to Custom request
             * by php artisan make:request Channels/UpdateChannelRequest
             * 
             */
            if($request->hasFile('image'))
            {
                /**
                 * one image at atime can be used ..if user updates
                 * image then the previous image will delete nd only new image 
                 * will be save
                 */
                $channel->clearMediaCollection('images');
                $channel->addMediaFromRequest('image')->toMediaCollection('images');
    
            }
            // dd($channel->image());
            $channel->update([
                'name' =>$request->name,
                'description'=> $request->description
            ]);
            return redirect()->back();
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        // $this->authorize('update', $channel);
    }
}
