<ul class="header-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">
    @foreach($items as $item)
    <li class="header-menu-item">
    @if($item->is_link)
        <a href='{{ $item->extra }}'>{{ $item->title }}</a>
    @else
        <a>{{ $item->title }}</a>
        <div class="dropdown-content">
            <div class="main-menu">
                @if(count($item->items[0]->children) > 0)
                    @foreach($item->items as $item)
                    <div class="menu-col">
                        <div class="menu-header">
                            <a href="{{ $item->extra }}">
                                {{ $item->title }}
                            </a>
                        </div>
                        @foreach($item->children as $item)
                        <a href="{{ $item->extra }}">
                            {{ $item->title }}
                        </a>
                        @endforeach
                    </div>
                    @endforeach
                @else
                    <div class="menu-col">
                        @foreach($item->items as $item)
                        <a href="{{ $item->extra }}">
                            {{ $item->title }}
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
    </li>
    @endforeach
</ul>
