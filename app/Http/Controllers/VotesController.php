<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Video;
use App\Models\Votes;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function vote($entity_id, $type){
        /**
         * to update vote if already voted and if not then create new Vote..
         * this is Define in User Model
         */
        $entity = $this->getEntity($entity_id); //this is define inthis controller
       return auth()->user()->toggleVote($entity, $type);
    }

    /***
     * whether we are voting for comment or video this function is going to work
     */
    public function getEntity($entity_id){
        $video = Video::find($entity_id);
        if($video){
            return $video;
        }
        $comment = Comment::find($entity_id);
        if($comment){
            return $comment;
        }

        throw new ModelNotFoundException('Entity not Found.');
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
     * @param  \App\Models\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function show(Votes $votes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function edit(Votes $votes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Votes $votes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Votes  $votes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Votes $votes)
    {
        //
    }
}
