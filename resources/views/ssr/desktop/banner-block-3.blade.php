<div class="full-width-wrapper banner-block-full-width-wrapper banner-block-full-width-wrapper_3 {{ $args->align }}">
    <div class="common" style='position: relative'>
        <div class="full-width-wrapper banner-block {{ $args->align }}">
            <div class="banner-block__image" ng-style="{'background-image': 'url({{ $args->img }})'}"></div>
            <div class="info">
                <div class='info__items'>
                    <div>
                        {!! $h1 !!}
                    </div>
                    <div class='lines'>
                        @foreach ($lines as $line)
                        <div class='line'>
                            <i class="fas fa-check"></i>
                            <span>{{ $line }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="gradient"></div>
        </div>
    </div>
</div>
<center style='margin-bottom: 3px' id='service-list-button'>
    <button class="btn-border" onclick="$('#service-list-button').remove(); $('.service-list').show(0)">дополнительные услуги</button>
</center>
<style>
    .service-list {
        display: none;
    }
</style>
