@extends('layouts.layout')
@section('content')

    <h2 class="text-center">
        {{$user->username}}
        <a href="{{route('user.follow', ['username' => $user->username])}}" title="{{$follow? 'UnFollow' : 'Follow'}}"><i class="fa fa-star{{$follow ? '' : '-o'}}" aria-hidden="true"></i></a>
    </h2>
    @include('tweets.tweets')
@stop