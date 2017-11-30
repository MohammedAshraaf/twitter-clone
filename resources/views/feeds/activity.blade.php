@extends('layouts.layout')
@section('content')
    <div class="row" >
        <div class="col-md-6">
            <h2 class="text-center">{{trans('tweets.mentions')}}</h2>

            @foreach($mentions as $mention)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="text-center col-md-12 col-xs-12 col-sm-12">
                                {{$mention->created_at}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('user.view', ['username' => $mention->mention->username])}}">
                            {{$mention->mention->username}}
                        </a>
                        {{' has mentioned you in his '}}
                        <a href="{{route('tweet.show', ['id' => $mention->tweet_id])}}">
                            {{trans('tweets.tweet')}}
                        </a>
                    </div>

                </div>
            @endforeach

            {{$mentions->appends(['likes' => $likes->currentPage(), 'tweets' => $followers->currentPage()])->links()}}
        </div>
        <div class="col-md-6">
            <h2 class="text-center">{{trans('likes.likes')}}</h2>

            @foreach($likes as $like)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="text-center col-md-12 col-xs-12 col-sm-12">
                                {{$mention->created_at}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('user.view', ['username' => $mention->mention->username])}}">
                            {{$mention->mention->username}}
                        </a>
                        {{' has Liked your '}}
                        <a href="{{route('tweet.show', ['id' => $mention->tweet_id])}}">
                            {{trans('tweets.tweet')}}
                        </a>
                    </div>
                </div>
            @endforeach
                {{$likes->appends(['mentions' => $mentions->currentPage(), 'tweets' => $followers->currentPage()])->links()}}

        </div>
        <div class="col-md-12">
            <h2 class="text-center">{{trans('tweets.tweets')}}</h2>
            @foreach($followers as $follower)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-9 col-xs-6 col-sm-6" style=" font-weight: bold">
                                <a href="{{route('user.view', ['username' => $follower->username])}}">
                                    {{$follower->username}}
                                </a>
                                {{'has created a '}}
                                <a href="{{route('tweet.show', ['id' => $follower->tweet_id])}}">
                                    {{trans('tweets.tweet')}}
                                </a>
                            </div>
                            <div class="col-md-3 col-xs-6 col-sm-6">
                                {{$follower->created_at}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">{{$follower->tweet}}</div>
                </div>
            @endforeach
            {{ $followers->appends(['mentions' => $mentions->currentPage(), 'likes' => $likes->currentPage()])->links() }}
        </div>
    </div>
@stop