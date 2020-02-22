<div class="service-list">
    {{-- FIRST ITEM --}}
    @if ($firstItem)
        <div class="service-list_one-line">
            @if ($firstItem->title)
                <div class='header-3'>{{ $firstItem->title }}</div>
            @endif

             <div style='margin-bottom: 15px'>
                {!! $firstItem->description !!}
             </div>
        </div>
    @endif
</div>
