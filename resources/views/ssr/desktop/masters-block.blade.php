
<div class="full-width-wrapper full-page-masters">
    @if (count($items) > 1)
        <div class="common main-page-masters masters-count-{{ count($items) }} {{ $all ? 'masters-all' : '' }}">
            @if (! $all)
                <div class="more-masters">
                    <div class='header-2'>{{ $title }}</div>
                    <div>{{ $desc }}</div>
                </div>
            @endif

            @foreach ($items as $index => $item)
                <div @if ($item === null) class='invisible' @endif>
                    <div>
                        <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                            <img src='{{ $item->photo_url }}' class="master-photo pointer">
                        </a>
                    </div>
                    <b class="pointer master-name">
                        <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                            {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}
                        </a>
                    </b>
                    <span>{{ $item->description }} <a href='/masters/{{ $item->id }}/'>Подробнее...</a></span>
                </div>
            @endforeach
        </div>
        <center class='more-button' style='margin: 50px 0 0'>
            <a class='no-style-link' href='/masters/'>
                <button class="btn-border">смотреть всех</button>
            </a>
        </center>
    @else
        <div class="common main-page-masters masters-count-1">
            <div>
                <a class='no-style-link' href='/masters/{{ $items[0]->id }}/'>
                    <img src='{{ $items[0]->photo_url }}' class="master-photo pointer">
                </a>
            </div>
            <div>
                <b class="master-name" style='margin: 0'>{{ $title }}</b>
                <b class="pointer master-name">
                    <a class='no-style-link' href='/masters/{{ $items[0]->id }}/'>
                        {{ $items[0]->first_name }} {{ $items[0]->middle_name }} {{ $items[0]->last_name }}
                    </a>
                </b>
                <span class="master-desc">{{ $items[0]->description }} <a href='/masters/{{ $items[0]->id }}/'>Подробнее...</a></span>
            </div>
        </div>
    @endif
</div>
