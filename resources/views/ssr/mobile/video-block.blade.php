<div class='header-1'>{{ $title }}</div>
<div class="vertical-slider" ng-if='true' ng-init='options = {!! json_encode($options) !!}' style='margin-bottom: 20px'>
    <div class="main-gallery-wrapper">
        @foreach ($items as $index => $item)
        <div class="gallery-item">
            <div style='position: relative'>
                <iframe id='youtube-video-{{ $item->id }}' width="288" height="144" data-id="{{ $item->id }}" class='youtube-video'
                        src="https://www.youtube.com/embed/{{ $item->code }}?enablejsapi=1&showinfo=0&rel=0" frameborder="0" allowfullscreen></iframe>
                <span id='video-duration-{{ $item->id }}' class="video-duratoin"></span>
            </div>
            <div>
                <b>{{ $item->title }}</b>
            </div>
        </div>
        @endforeach
    </div>
</div>
