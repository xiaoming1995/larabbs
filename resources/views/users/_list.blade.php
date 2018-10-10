@if (count($lists))

<ul class="list-group">
    @foreach ($lists as $list)
        <li class="list-group-item">
            <a href="{{ route('users.show',$list->id) }}">
                {{ $list->name }}
            </a>
            <span class="meta pull-right">
                关注于
                <span> ⋅ </span>
                {{ $list->pivot->created_at->diffForHumans() }}
            </span>
        </li>
    @endforeach
</ul>

@else
   <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
{{ $lists->render() }}