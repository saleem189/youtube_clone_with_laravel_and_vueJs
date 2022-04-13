@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} {{auth()->user()->name}}  {{auth()->user()->role}}</div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Search') }}</div>

                <div class="card-body">
                <!-- vue search component -->
                <search></search>
                <!-- end Component -->

            </div>
            </div>
        </div>
    </div>
</div>

@if ($channels->count() !==0)
    

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Searched Channels') }}</div>
                
                
                <div class="card-body">
                    
                        @foreach ($channels as $channel )
                        {{ $channel->name }}
                        <a href="{{ route ('channels.show',$channel->id)}} " class="btn btn-sm btn-info"> View Channel</a>
                        @endforeach

                        {{$channels->appends(request()->query())->links()}}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@if ($videos->count() !==0)
    

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Searched Videos') }}</div>
                
                
                <div class="card-body">
                    <form action="" method="get">
                        @foreach ($videos as $video )
                        {{ $video->title }}
                        <a href="{{ route ('videos.show',$video->id)}} " class="btn btn-sm btn-info"> View video</a>
                        @endforeach

                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@endsection
