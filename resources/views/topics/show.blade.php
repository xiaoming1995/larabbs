@extends('layouts.app')

@section('title', $topic->title)
@section('description', $topic->excerpt)

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-center">
                    作者：{{ $topic->user->name }}
                </div>
                <hr>
                <div class="media">
                    <div align="center">
                        <a href="{{ $topic->link() }}" title="{{ $topic->title }}">
                            <img class="thumbnail img-responsive" src="{{ $topic->user->avatar }}" width="300px" height="300px">
                        </a>
                    </div>
                </div>
                <hr>
                <div>
                    @if(!empty(Auth::user()))
                        @if(Auth::user()->isAttention($topic->user_id))
                        <a href="{{ route('user.attention',[$topic->user_id]) }}" class="btn btn-info btn-block" aria-label="Left Align" title="点击取消关注">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 已关注
                        </a>
                        @elseif(Auth::user()->id !== $topic->user_id)
                        <a href="{{ route('user.attention',[$topic->user_id]) }}" class="btn btn-success btn-block" aria-label="Left Align" title="点击关注">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 关注用户
                        </a>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 topic-content">
        <div class="panel panel-default">
            <div class="panel-body">
                <h1 class="text-center">
                    {{ $topic->title }}
                </h1>

                <div class="article-meta text-center">
                    {{ $topic->created_at->diffForHumans() }}
                    ⋅
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                    {{ $topic->reply_count }}
                </div>

                <div class="topic-body">
                    {!! $topic->body !!}
                </div>

                @can('update', $topic)
                    <div class="operate">
                        <hr>
                        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-default btn-xs pull-left" role="button">
                            <i class="glyphicon glyphicon-edit"></i> 编辑
                        </a>

                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-default btn-xs pull-left" style="margin-left: 6px">
                                <i class="glyphicon glyphicon-trash"></i>
                                删除
                            </button>
                        </form>
                    </div>
                @endcan

            </div>
        </div>

        {{-- 用户回复列表 --}}
        <div class="panel panel-default topic-reply">
            <div class="panel-body">
                @includeWhen(Auth::check(), 'topics._reply_box', ['topic' => $topic])
                @include('topics._reply_list', ['replies' => $topic->replies()->with('user')->get()])
            </div>
        </div>
        

       
        
    </div>
</div>
@stop