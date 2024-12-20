@props([
    'label' => '',
    'url'   => '',
    'icon' => '',
    'sublinks' => [],
    'active' => false
])
<li class="treeview {{ $active ? 'active' : '' }}">
    <a href="{{$url}}">
        @if($icon)
            <i class="{{$icon}}"></i>
        @endif
        <span>{{$label}}</span>
        @if($sublinks)
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        @endif

    </a>
    @if($sublinks)
        <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
        </ul>
    @endif

</li>
