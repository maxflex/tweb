@if ($args->type === 'side')
    <div class="equipment-item {{ $args->align }}">
        <div>
            <img src='{{ $item->photo_url }}' class="equipment-photo">
        </div>
        <div class="header-1 padding-top">{{ $item->name }}</div>
        <div>
            <span>{{ $item->description }}</span>
            <div>
                @if ($item->button)
                    <button class="btn-border" href="equipment/{{ $item->id }}/">продробнее...</button>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="equipment-item equipment-full {{ $item->contrast }}" style="background: #{{ $item->color }}">
        <div class="equipment-img-container">
            <img src='{{ $item->photo_url }}' class="equipment-photo">
            <div class="equipment-overlay"
                style="background: linear-gradient(to top, #{{ $item->color }} 0%, transparent 100%"></div>
        </div>
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
    </div>
@endif
