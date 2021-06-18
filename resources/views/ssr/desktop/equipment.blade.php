@if ($args->type === 'side')
    <div class="equipment-item {{ $args->align }}">
        <div>
            <img src='{{ $item->photo_url }}' loading="lazy" class="equipment-photo">
        </div>
        <div>
            <div>
                <b>{{ $item->name }}</b>
                <span>{{ $item->description }}</span>
                <div>
                    @if ($item->button)
                        <button class="btn-border" href="equipment/{{ $item->id }}/">продробнее...</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <div class="equipment-item-full {{ $args->align }} {{ $item->contrast }}">
        <div class="equipment-additional-block" style="background: #{{ $item->color }}"></div>
        <div class="equipment-overlay"
            style="background: linear-gradient(to {{ $args->align === 'left' ? 'right' : 'left' }}, #{{ $item->color }} 33%, transparent 95%)"></div>
        <div class="equipment-image">
            <img src='{{ $item->photo_url }}' loading="lazy" class="equipment-photo">
        </div>
        <div class="equipment-text-block">
            <div>
                <b>{{ $item->name }}</b>
                <span>{{ $item->description }}</span>
                @if ($item->button)
                    <button class="btn-border" href="equipment/{{ $item->id }}/">продробнее...</button>
                @endif
            </div>
        </div>
    </div>
@endif
