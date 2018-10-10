@extends('layouts.app')

@if($type == 'attentions')
@section('title', $user->name . ' 的关注列表 ')

@else

@section('title', $user->name . ' 的粉丝列表 ')

@endif

@section('content')
<div class="row">

  
    @include('users._user_info',['user'=>$user])
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
                </span>
            </div>
        </div>

        @if($type == 'attentions')
            @include('users._list', ['lists' => $user->attention()->with('attention')->latest()->paginate(10)])
        @else
            @include('users._list', ['lists' => $user->followers()->with('attention')->latest()->paginate(10)])
        @endif

    </div>
</div>
@stop




