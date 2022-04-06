@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if($video->editable())
                <form action="{{ route('videos.update',$video->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    @endif

                    <div class="card-header">{{ $video->title }}</div>


                    <div class="card-body">
                        <video-js id="video_id" class="vjs-default-skin" controls preload="auto" width="640"
                            height="268">
                            <source src='{{ asset(Storage::url("videos/{$video->id}.m3u8"))}}'
                                type="application/x-mpegURL">
                        </video-js>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mt-3">
                                    @if($video->editable())
                                    <input type="text" class="form-control" value="{{$video->title}}" name="title">
                                    @else
                                    {{$video->title}}
                                    @endif
                                </h4>
                                <!-- we are using laravel Plural Function here -->
                                {{$video->views}} {{ Str::plural('view', $video->views) }}
                            </div>

                            <!-- we are passing video->channel->owner  as entity in string that why we are not using :entity_owner  -->
                            <votes :default_votes='{{ $video->votes }}' entity_owner="{{$video->channel->user_id}}"
                                entity_id="{{$video->id}}"></votes>


                        </div>
                        <hr>
                        <div>
                            @if($video->editable())
                            <textarea name="description" id="" cols="3" rows="3"
                                class="form-control">{{$video->description}}</textarea>
                            <div class="text-right mt-3">
                                <button class="btn btn-info btn-sm" type="submit"> Update video details </button>
                            </div>
                            @else
                            {{$video->description}}
                            @endif
                        </div>
                        <hr>
                        <h3>{{$video->channel->name}}</h3>
                        <h4>{{$video->created_at->toFormattedDateString()}}</h4>
                    </div>
                    <subscribe-button :subscriptions-list="{{$video->channel->subscriptions}}"
                        :channel="{{$video->channel}}" />

                    @if($video->editable())
                </form>
                @endif
            </div>
        </div>
    </div>
    <comments :video="{{$video}}"></comments>
</div>


@endsection

@section('styles')
<link href="{{ asset('css/js-video-player.css') }}" rel="stylesheet">
<style>
    .w-full {
        width: 100% !important;
    }

    .w-80 {
        width: 80% !important;
    }

</style>
@endsection

@section('scripts')

<script src="{{ asset('js/js-video-player.js') }}"></script>
<script>
    window.CURRENT_VIDEO = '{{ $video->id }}'

</script>
<script src="{{ asset('js/js-video-custom-functions.js') }}"></script>
@endsection
