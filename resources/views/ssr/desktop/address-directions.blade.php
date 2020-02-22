<div class="service-list" style="margin-top: 0">
    {{-- FIRST ITEM --}}
    @if ($firstItem)
        <div class="service-list__items service-list__items_one-line">
            <div style='width: 100%; display: flex; align-items: center;'>
                <div>
                    @if ($firstItem->title)
                        <a class='no-style-link' href='/{{ $firstItem->link_url }}/'>
                            <div class='header-3 pointer'>{{ $firstItem->title }}</div>
                        </a>
                    @endif
                    <span class='service-list__item-description'>
                        {!! $firstItem->description !!}
                    </span>
                </div>
            </div>
        </div>
    @endif
</div>
