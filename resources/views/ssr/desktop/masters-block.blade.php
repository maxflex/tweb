
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
    @else
        <div class="common main-page-masters masters-count-1">
            <div>
                <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                    <img src='{{ $item->photo_url }}' class="master-photo pointer">
                </a>
            </div>
            <div>
                <b class="master-name" style='margin: 0'>{{ $title }}</b>
                <b class="pointer master-name">
                    <a class='no-style-link' href='/masters/{{ $item->id }}/'>
                        {{ $item->first_name }} {{ $item->middle_name }} {{ $item->last_name }}
                    </a>
                </b>
                <span class="master-desc">>{{ $item->description }} <a href='/masters/{{ $item->id }}/'>Подробнее...</a></span>
            </div>
        </div>
    @endif
</div>
