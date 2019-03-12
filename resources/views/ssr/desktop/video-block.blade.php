<div class='header-1'>{{ $title }}</div>
<div class="video-block" ng-if='true' ng-init='options = {!! json_encode($options) !!}'>
    <div class="video-wrapper">
        @foreach ($items as $index => $item)
            <div class="gallery-item" ng-hide='options.show <= {{ $index }}'>
                <div style='position: relative'>
                    <iframe id='youtube-video-{{ $item->id }}' width="288" height="144" data-id="{{ $item->id }}" class='youtube-video'
                        src="https://www.youtube.com/embed/{{ $item->code }}?enablejsapi=1&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>
                    <span id='video-duration-{{ $item->id }}' class="video-duratoin"></span>
                </div>
                <div>
                    <h3 class="entity-header">{{ $item->title }}</h3>
                </div>
            </div>
        @endforeach
    </div>
    <center ng-show='options.show < {{ count($items) }}' class='more-button'>
        <button class="btn-border" ng-click="options.show = options.show + options.showBy">показать ещё</button>
    </center>
</div>
