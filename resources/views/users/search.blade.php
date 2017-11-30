@extends('layouts.layout')
@section('content')
    @if($users)
        <div class="container">
            <h2 class="text-center">
                {{trans('general.results')}}
            </h2>
            <div class="row">
                @foreach($users as $user)
                    <div class="col-xs-12">
                        <h3><a href="{{route('user.view', ['id' => $user->username])}}">{{$user->username}}</a></h3>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h2>
            {{trans('general.resultsNotFound')}}
        </h2>
    @endif
@stop