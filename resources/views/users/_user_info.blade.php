<div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="media">
                    <div align="center">
                        <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px">
                    </div>
                    <div class="media-body">
                        <div style="display: flex;margin-top:20px;align-items: center;">
                            <a href="{{ route('user.list',[$user->id,'attentions']) }}" style="width 3rem;height 3rem;display block;background #ccc;width:33.33333333%;text-decoration: none">
                                <p style="text-align: center;color:#d6514d;font-size:25px">{{ $user->attention->count() }}</p>
                                <p style="text-align: center;">关注</p>
                            </a>
                            <a href="{{ route('user.list',[$user->id,'followers']) }}" style="width 3rem;height 3rem;display block;background #ccc;width:33.33333333%;text-decoration: none">
                                <p style="text-align: center;color:#d6514d;font-size:25px">{{ $user->followers->count() }}</p>
                                <p style="text-align: center;">粉丝</p>
                            </a>
                            <a href="" style="width 3rem;height 3rem;display block;background #ccc;width:33.33333333%;text-decoration: none">
                                <p style="text-align: center;color:#d6514d;font-size:25px">{{ $user->topics->count() }}</p>
                                <p style="text-align: center;">帖子</p>
                            </a>
                        </div>
                        <hr>
                        <div>
                            @if(Auth::user()->isAttention($user->id))
                            <a href="{{ route('user.attention',[$user->id]) }}" class="btn btn-info btn-block" aria-label="Left Align" title="点击取消关注">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 已关注
                            </a>
                            @elseif(Auth::user()->id == $user->id )
                            <a href="{{ route('users.edit', Auth::id()) }}" class="btn btn-primary btn-block" aria-label="Left Align" title="编辑个人资料">
                                <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 编辑个人资料
                            </a>
                            @else
                            <a href="{{ route('user.attention',[$user->id]) }}" class="btn btn-success btn-block" aria-label="Left Align" title="点击关注">
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 关注用户
                            </a>
                            @endif
                        </div>
                        <hr>
                        <h4><strong>个人简介</strong></h4>
                        <p>{{ $user->introduction }}</p>
                        <hr>
                        <h4><strong>注册于</strong></h4>
                        <p>{{ $user->created_at->diffForHumans() }}</p>
                        <hr>
                        <h4><strong>最后活跃</strong></h4>
                        <p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>