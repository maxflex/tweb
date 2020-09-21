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
                                <span class='metro-circle line-5'></span>
                                <span>Октябрьская</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-6'></span>
                                <span>Ленинский проспект</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-6'></span>
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
                                <span class='metro-circle line-7'></span>
                                <span>Полежаевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-8'></span>
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
                                <span class='metro-circle line-9'></span>
                                <span>Цветной бульвар</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-10'></span>
                                <span>Достоевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-9'></span>
                                <span>Менделеевская</span>
                            </div>
                            <div class='flex-items-center'>
                                <span class='metro-circle line-5'></span>
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
