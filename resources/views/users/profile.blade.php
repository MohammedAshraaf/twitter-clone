@extends('layouts.layout')
@section('content')

    <h2 class="text-center">
        {{$user->username}}
    </h2>

    <div style="margin-bottom: 5%">
        <form action="{{route('tweet.create')}}" method="POST" role="form" id="profile">
            {{csrf_field()}}
            <div class="form-group {{($errors->has('tweet'))?'has-error':''}}">
                <label for="tweet">{{trans('tweets.tweet')}}:</label>
                <textarea name="tweet" class="form-control" id="tweet"></textarea>
                {!! $errors->first('tweet', '<p class="help-block">:message</p>') !!}
            </div>
            <div class="form-group {{($errors->has('mention'))?'has-error':''}}">
                <div >
                    <label for="mention">{{trans('tweets.mention')}}:</label>
                    <select id="mention" name="mention" class="form-control">

                    </select>
                </div>
                {!! $errors->first('mention', '<p class="help-block">:message</p>') !!}
            </div>
            <button type="submit" class="btn btn-primary">{{trans('general.submit')}}</button>
        </form>
    </div>
    @include('tweets.tweets')
@stop
@section('extra-css')
    <link rel="stylesheet" href="{{asset('css/select2.min.css')}}">
@stop
@section('extra-js')
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script>
        $('#mention').select2({
            ajax: {
                url: '{{route('user.search.ajax')}}',
                dataType: 'json',
                data: function(params){
                    return {
                        search: params.term,
                        page: params.page || 1
                    }

                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    console.log(data);
                    return {
                        results: $.map(data['results'], function (item) {
                            return {
                                text: item.username,
                                id: item.id
                            }
                        })
                    };
                }
            },
            minimumInputLength: 3
        });
        $('.btn-danger').click(function (e) {
            e.preventDefault();
            if(confirm("{{trans('tweets.confirmDelete')}}"))
                $(this).parent().submit();

        })
    </script>
@stop
