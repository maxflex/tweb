@if ($args->type === 'side')
    <div class="equipment-item {{ $args->align }}">
        <div class="header-1 padding-top">{{ $item->name }}</div>
        <div>
            <span>{{ $item->description }}</span>
            <div>
                @if ($item->button)
                    <button class="btn-border" href="equipment/{{ $item->id }}/">продробнее...</button>
                @endif
            </div>
        </div>
        <div>
            <img src='{{ $item->photo_url }}' class="equipment-photo">
        </div>
    </div>
@else
    <div class="equipment-item equipment-full">
        <div class="common" style='padding-bottom: 1.2em'>
            <div class='header-1'>{{ $item->name }}</div>
            <div>
                <span>{{ $item->description }}</span>
                <div>
                    @if ($item->button)
                        <button class="btn-border" href="equipment/{{ $item->id }}/">продробнее...</button>
                    @endif
                </div>
            </div>
        </div>
        <div class="equipment-img-container">
            <img src='{{ $item->photo_url }}' class="equipment-photo">
        </div>
    </div>
@endif
