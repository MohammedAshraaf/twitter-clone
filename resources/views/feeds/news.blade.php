@extends('layouts.layout')
@section('content')

    <h2 class="text-center">{{trans('general.newsFeed')}}</h2>
    @foreach($followers as $follower)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-9 col-xs-6 col-sm-6" style="color:#3c8dbc; font-weight: bold">
                            <a href="{{route('user.view', ['username' => $follower->username])}}">{{$follower->username}}</a>
                        </div>
                        <div class="col-md-3 col-xs-6 col-sm-6">
                            {{trans('general.createdAt') . ' ' . $follower->created_at}}
                        </div>
                    </div>
                </div>
                <div class="panel-body">{{$follower->tweet}}</div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-md-2 col-xs-6 col-sm-3">

                            <a href="{{route('likes.like', ['tweet' => $follower->tweet_id])}}" >
                                <i class="fa fa-heart{{($likes[$follower->tweet_id]) ? '' : '-o'}}" style="font-size: 25px; margin-top: 2%"></i>
                            </a>
                            <span style="margin-left: 5%; font-size: 22px">{{$likesCounter[$follower->tweet_id]}}</span>
                        </div>
                    </div>
                </div>
            </div>
    @endforeach
    {{ $followers->links() }}
@stop