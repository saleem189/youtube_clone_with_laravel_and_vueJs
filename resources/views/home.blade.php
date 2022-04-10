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
                <form action="" method="get">
                    <input type="text" name="search" class="form-control" placeholder="Search Video or channel here">
                </form>
            </div>
            </div>
        </div>
    </div>
</div>


<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Searched Videos') }}</div>


                <div class="card-body">
                <form action="" method="get">
                    @foreach ($channels as $channel )
                        {{$channel->name}}
                        <a href="{{ route ('channel.show',$chennel->id)}} " class="btn btn-sm btn-info"> View Channel</a>
                    @endforeach
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
