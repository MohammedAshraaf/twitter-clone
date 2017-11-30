@extends('layouts.layout')
@section('content')
<div id="tweets">
    <h3 class="text-center"><a href="{{route('user.view', ['username' => $user->username])}}"> {{$user->username}}</a></h3>

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-9 col-xs-6 col-sm-6" style="color:#3c8dbc; font-weight: bold">
                        <a href="{{route('user.view', ['username' => $user->username])}}">{{$user->username}}</a>
                    </div>
                    <div class="col-md-3 col-xs-6 col-sm-6">
                        {{trans('general.createdAt') . ' ' . $tweet->created_at}}
                    </div>
                </div>
            </div>
            <div class="panel-body">{{$tweet->tweet}}</div>
            <div class="panel-footer">
                <div class="row">

                    <div class="col-md-2 col-xs-6 col-sm-3">

                        <a href="{{route('likes.like', ['tweet' => $tweet->id])}}" >
                            <i class="fa fa-heart{{$like ? '' : '-o'}}" style="font-size: 25px; margin-top: 2%"></i>
                        </a>
                        <span style="margin-left: 5%; font-size: 22px">{{count($tweet->likes)}}</span>
                    </div>
                </div>
            </div>
        </div>
</div>
@stop