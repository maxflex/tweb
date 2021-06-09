<div class='header-1'>{{ $title }}</div>
<div class="vertical-slider gallery-block-photo" ng-init="video.service.init({{ json_encode($args) }}, 'video', video.onLoaded)" style='margin-bottom: 20px'>
    <iframe id='youtube-video' frameborder="0" allowfullscreen
        height="144" width="288"
        src='https://www.youtube.com/embed?enablejsapi=1&rel=0&amp;showinfo=0'>
    </iframe>
    <div class="main-gallery-wrapper">
        @foreach ($data->items() as $index => $item)
        <div class="gallery-item" onclick="openVideoMobile('{{ $item->code }}')"
            @if($index === count($data->items()) - 1) in-view="firstLoadMoreInView(video)" @endif
        >
            <div class='video-item'>
                <img src='{{ $item->url }}' />
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
                <b>{{ $item->title }}</b>
            </div>
        </div>
        @endforeach
        <div ng-repeat="item in video.items track by $index" class="gallery-item"
            in-view="loadMoreInView(video, $index, $inview)"
            ng-click="video.open(item)"
        >
            <div class='video-item'>
                <img ng-src='@{{ item.url }}' />
                <div class="youtube-video-info">
                    <div class='youtube-video-info__channel-logo'></div>
                    <div class='youtube-video-info__title'>
                        @{{ item.title_short }}
                    </div>
                </div>
                <button class="ytp-large-play-button ytp-button" aria-label="Смотреть"><svg height="100%" version="1.1" viewBox="0 0 68 48" width="100%"><path class="ytp-large-play-button-bg" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#212121" fill-opacity="0.8"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg></button>
                <span class="video-duratoin" ng-if="item.duration">
                    @{{ item.duration }}
                </span>
            </div>
            <div>
                <b>@{{ item.title }}</b>
            </div>
        </div>
    </div>
</div>
