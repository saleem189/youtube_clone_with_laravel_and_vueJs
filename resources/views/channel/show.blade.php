@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $channel->name }} 
                    <a href="{{route('channel.upload', $channel->id) }}">Upload Video</a>
                </div>

                <div class="card-body">
                @if($channel->editable())
                    <form id="update-channel-form" action=" {{ route ('channels.update',$channel->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        @endif

                        <div class="form-group row justify-content-center">
                            <div class="channel-avatar">
                            @if($channel->editable())
                                <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay">

                                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60"
                                        style="enable-background:new 0 0 60 60;" xml:space="preserve">
                                        <path d="M48.014,42.889l-9.553-4.776C37.56,37.662,37,36.756,37,35.748v-3.381c0.229-0.28,0.47-0.599,0.719-0.951
                                        c1.239-1.75,2.232-3.698,2.954-5.799C42.084,24.97,43,23.575,43,22v-4c0-0.963-0.36-1.896-1-2.625v-5.319
                                        c0.056-0.55,0.276-3.824-2.092-6.525C37.854,1.188,34.521,0,30,0s-7.854,1.188-9.908,3.53C17.724,6.231,17.944,9.506,18,10.056
                                        v5.319c-0.64,0.729-1,1.662-1,2.625v4c0,1.217,0.553,2.352,1.497,3.109c0.916,3.627,2.833,6.36,3.503,7.237v3.309
                                        c0,0.968-0.528,1.856-1.377,2.32l-8.921,4.866C8.801,44.424,7,47.458,7,50.762V54c0,4.746,15.045,6,23,6s23-1.254,23-6v-3.043
                                        C53,47.519,51.089,44.427,48.014,42.889z M51,54c0,1.357-7.412,4-21,4S9,55.357,9,54v-3.238c0-2.571,1.402-4.934,3.659-6.164
                                        l8.921-4.866C23.073,38.917,24,37.354,24,35.655v-4.019l-0.233-0.278c-0.024-0.029-2.475-2.994-3.41-7.065l-0.091-0.396l-0.341-0.22
                                        C19.346,23.303,19,22.676,19,22v-4c0-0.561,0.238-1.084,0.67-1.475L20,16.228V10l-0.009-0.131c-0.003-0.027-0.343-2.799,1.605-5.021
                                        C23.253,2.958,26.081,2,30,2c3.905,0,6.727,0.951,8.386,2.828c1.947,2.201,1.625,5.017,1.623,5.041L40,16.228l0.33,0.298
                                        C40.762,16.916,41,17.439,41,18v4c0,0.873-0.572,1.637-1.422,1.899l-0.498,0.153l-0.16,0.495c-0.669,2.081-1.622,4.003-2.834,5.713
                                        c-0.297,0.421-0.586,0.794-0.837,1.079L35,31.623v4.125c0,1.77,0.983,3.361,2.566,4.153l9.553,4.776
                                        C49.513,45.874,51,48.28,51,50.957V54z" /><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>
                                    </svg>



                                </div>
                                
                                @endif
                                {{ $channel->image() }}
                                

                                
                                <img src="{{ $channel->image() }}" alt="dp">

                            </div>
                        </div>
                        <div class="form-group">
                            <h4 class="text-center">
                                {{$channel->name}}
                            </h4>
                            <p class="text-center">
                                {{$channel->description}}
                            </p>
                            <div class="text-center">
                                <subscribe-button :subscriptions-list="{{$channel->subscriptions}}":channel="{{$channel}}"/>
                            </div>
                        </div>



                       
                        @if($channel->editable())
                        <input hidden onchange="document.getElementById('update-channel-form').submit()" type="file"
                            name="image" id="image">

                        <div class="form-group">
                            <label for="name" class="form-control-label">
                                Name
                            </label>
                            <input id="name" name="name" value="{{$channel->name}}" class="form-control"></input>
                        </div>
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                        <div class="form-group">
                            <label for="description" class="form-control-label">
                                Description
                            </label>

                            <textarea id="description" name="description" value="{{$channel->description}}"
                                class="form-control" cols="3" rows="3">
                           {{$channel->description}}
                           </textarea>
                           @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                       

                        @if($errors->any())
                        <ul class="list-group mb-5">
                            @foreach($errors->all() as $error)
                            <li class="text-danger list-group-item">
                                {{$error}}
                            </li>
                            @endforeach
                        </ul>
                        @endif
                        
                        


                        <button type="submit" class="btn btn-info">Update</button>
                        @endif
                        

                        @if($channel->editable())
                    </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
