<!-- Side menu -->
<div class='modal' id='modal-menu' style='padding-bottom: 40px'>
    <div class='modal-button modal-button-top' onclick='eventAction("mob-burger-close"); closeModal()'></div>
    <div class='modal-content with-close-button' id='menu-overlay' style='overflow-x: hidden'>
        @foreach ($items as $section)
            <div class='header-1'>{{ $section->title }}</div>
            <div class='expander'>
                <div class='expander__item'>
                    <ul @if ($section->onlyLinks()) class='only-links' @endif>
                        @foreach ($section->items as $item)
                            @include('mobile-menu-item', [
                                'item' => $item,
                                'level' => 0,
                            ])
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
</div>
