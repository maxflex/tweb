<ul class="header-menu" itemscope itemtype="http://schema.org/SiteNavigationElement">
    @foreach($items as $item)
    <li class="header-menu-item">
    @if($item->is_link)
        <a href='{{ $item->extra }}'>{{ $item->title }}</a>
    @else
        <a>{{ $item->title }}</a>
        <div class="dropdown-content {{ $item->id === 26 ? 'right' : '' }}">
            <div class="main-menu">
                @if(count($item->items[0]->children) > 0)
                    @foreach($item->items as $item)
                    <div class="menu-col">
                        <div class="menu-header">
                            @if($item->is_link)
                            <a href="{{ $item->extra }}">
                                {{ $item->title }}
                            </a>
                            @else
                            <span class="menu-header">
                                {{ $item->title }}
                            </span>
                            @endif
                        </div>
                        @foreach($item->children as $item)
                        <a href="{{ $item->extra }}">
                            {{ $item->title }}
                        </a>
                        @if($item->desc)
                        <span class="menu-desc">
                            {{ $item->desc }}
                        </span>
                        @endif
                        @endforeach
                    </div>
                    @endforeach
                @else
                    <div class="menu-col">
                        @foreach($item->items as $item)
                        <a href="{{ $item->extra }}">
                            {{ $item->title }}
                        </a>

                        @if($item->id === 962)
                            @foreach($maps as $map)
                            <div class='menu-addr'>
                                <div class="fas fa-map-marker-alt"></div>
                                {{ $map['address'] }}
                            </div>
                            @endforeach
                            <div class="menu-metros"></div>
                        @endif

                        @if($item->id === 865)
                        <div class='menu-addr'>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $maps['len']['address'] }}
                        </div>
                        <div class='menu-metros'>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-5.svg" class='metro-svg'></img>
                                <span>Октябрьская</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-6.svg" class='metro-svg'></img>
                                <span>Ленинский проспект</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-6.svg" class='metro-svg'></img>
                                <span>Шаболовская</span>
                            </div>
                        </div>
                        @endif

                        @if($item->id === 866)
                        <div class='menu-addr'>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $maps['pol']['address'] }}
                        </div>
                        <div class='menu-metros'>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-7.svg" class='metro-svg'></img>
                                <span>Полежаевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-8.svg" class='metro-svg'></img>
                                <span>Хорошевская</span>
                            </div>
                        </div>
                        @endif

                        @if($item->id === 867)
                        <div class='menu-addr'>
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $maps['delegat']['address'] }}
                        </div>
                        <div class='menu-metros'>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-9.svg" class='metro-svg'></img>
                                <span>Цветной бульвар</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-10.svg" class='metro-svg'></img>
                                <span>Достоевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-9.svg" class='metro-svg'></img>
                                <span>Менделеевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <img src="/img/svg/metro/black/line-5.svg" class='metro-svg'></img>
                                <span>Новослободская</span>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif
    </li>
    @endforeach
</ul>
