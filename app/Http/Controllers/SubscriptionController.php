<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * we only need store and delete method for subscriptions
     * as we can see only store and delete will be used it this controller 
     * bc we can only subscribe and unsubscribe the channel 
     * 
     */
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
    public function store(Channel $channel,Request $request)
    {
        return $channel->subscriptions()->create([
            'user_id' => auth()->user()->id
        ]);
        // return response()->json($res) ;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Subscription $subscription)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    /**
     * we are using Route Modle Binding here 
     */
    public function destroy(Channel $channel, Subscription $subscription)
    {
        $subscription->delete();
        return response()->json('subscription Deleted');
    }
}
