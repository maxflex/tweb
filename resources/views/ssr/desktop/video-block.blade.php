<div class='header-1'>{{ $title }}</div>
<div class="video-block" ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    <div class="video-wrapper">
        @foreach ($items as $index => $item)
            <div class="gallery-item" ng-hide='options.show <= {{ $index }}' onclick="openVideo('{{ $item->code }}')">
                <div class='video-item' style="background-image: url(https://talisman.ams3.cdn.digitaloceanspaces.com/img/video/{{ $item->id }}.jpg)">
                    <div class="youtube-video-info">
                        <div class='youtube-video-info__channel-logo'></div>
                        <div class='youtube-video-info__title'>
                            {{ $item->title_short }}
                        </div>
                    </div>
                    <button class="ytp-large-play-button ytp-button" aria-label="Смотреть"><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#212121" fill-opacity="0.8"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg></button>
                    @if ($item->duration)
                    <span class="video-duratoin">
                        {{ $item->duration }}
                    </span>
                    @endif
                </div>
                <div>
                    <div class="header-3 entity-header">{{ $item->title }}</div>
                </div>
            </div>
        @endforeach
    </div>
    <center ng-show='options.show < {{ count($items) }}' class='more-button'>
        <button class="btn-border" ng-click="options.show = options.show + options.showBy">показать ещё</button>
    </center>
</div>

<div class='modal' id='modal-video'>
    <iframe id='youtube-video' style='width: 100%; height: 100%' frameborder="0" allowfullscreen
        src='https://www.youtube.com/embed?enablejsapi=1&rel=0&amp;showinfo=0'></iframe>
</div>

<div class="lightbox-background" onclick="closeModal()">
    <img src="/img/svg/cross-out.svg" class="close-cross">
</div>

{{-- <iframe id='youtube-video-{{ $item->id }}' width="288" height="144" data-id="{{ $item->id }}" class='youtube-video'
    src="https://www.youtube.com/embed/{{ $item->code }}?enablejsapi=1&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe> --}}
