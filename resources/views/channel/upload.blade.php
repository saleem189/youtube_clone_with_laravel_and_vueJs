@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        <channel-uploads :channel="{{ $channel }}" inline-template>
            <div class="col-md-8">
                <div class="card p-3 d-flex justify-content-center align-items-center" v-if="!selected">
                    <h3 onclick="document.getElementById('video_files').click()">click here to Uplad Video</h3>
                    <input type="file" multiple hidden id="video_files" ref="videos" @change="upload">
                </div>

                <div class="card p-3" v-else>
                    <div class="my-4" v-for="video in videos">
                        <div class="progress mb-3">
                            <!-- style binding in this div instead of status style eg style="width: 50%; into :style={width: `${progress[video.name]}%`} this is supposed to be object thats why we write it in {}S " -->
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" :style="{width: `${video.percentage || progress[video.name]}%`}" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                    @{{ video.percentage ? video.percentage ==100 ? 'Processing Completed' :'Processing':'Uploading'}}
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div v-if="!video.thumbnail" class="d-flex justify-content-center align-item-center" style="height: 18;">
                                        Loading Thumbnails.....
                                    </div>
                                    <img v-else :src="video.thumbnail" style="width: 100%;" alt="">
                                </div>

                                <div class="col-md-4">
                                    <a v-if="video.percentage && video.percentage ==100" :href="`/videos/${video.id}`" target="_blank">
                                    @{{video.title}}
                                    </a>
                                    <h4 v-else class="text-center">
                                        @{{video.title || video.name}}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                
            </div>
        </channel-uploads>
    </div>
</div>
@endsection
