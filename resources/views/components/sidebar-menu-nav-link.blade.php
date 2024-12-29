@props([
    'label' => '',
    'url'   => '',
    'icon' => '',
    'sublinks' => [],
    'active' => false
])
<li class="{{ $active ? 'active' : '' }} {{$sublinks ? 'treeview' : ''}}">
    <a href="{{$url}}">
        @if($icon)
            <i class="{{$icon}}"></i>
        @endif
        {{$label}}
        @if($sublinks)
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        @endif

    </a>
    @if($sublinks)
        <ul class="treeview-menu">
            @foreach($sublinks as $sublink)
                <li class="{{ str_contains(request()->path(), $sublink['url']) ? 'active' : '' }}"><a href="{{ url($sublink['url'])}}">{{$sublink['label']}}</a></li>
            @endforeach
        </ul>
    @endif

</li>
