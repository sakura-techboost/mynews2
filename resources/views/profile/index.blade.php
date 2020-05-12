@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="ff69b4">
        
        @if(!is_null($headline))
            <div class="row">
                <div class="headline col-md-10 mx auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="caption mx-auto">
                                <div class="name p-2">
                                    <h1>{{ str_limit($headline->name,20) }}</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="gender mx-auto">{{ str_limit($headline->gender,20) }}</p>
                            <p class="hobby mx-auto">{{ str_limit($headline->hobby,20) }}</p>
                            <p class="introduction mx-auto">{{ str_limit($headline->introduction,1000) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <hr color="ff69b4">
        <div class="row">
            <div class="posts col-md-8 mx-auto mt-3">
                @foreach($posts as $post)
                    <div class="post">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="date">
                                    {{ $post->updated_at->format('Y年m月d日') }}
                                </div>
                                <div class="name">
                                    {{ str_limit($post->name,20) }}
                                </div>
                                <div class="gender mt-3">
                                    {{ str_limit($post->gender,20) }}
                                </div>
                                <div class="hobby mt-3">
                                    {{ str_limit($post->hobby,20) }}
                                </div>
                            </div>
                            <div class="introduction col-md-6 text-right mt-4">
                                {{ str_limit($post->introduction,1000) }}
                            </div>
                        </div>
                    </div>
                    <hr color="ff69b4">
                @endforeach
            </div>
        </div>
    </div>
@endsection