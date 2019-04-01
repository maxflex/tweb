<div class="banner-block">
    <center>
        {!! $h1 !!}
    </center>
    <div class="full-width">
        <img src="{{ $args->img }}">
    </div>
</div>
<div class='service-list_one-line' style='margin-bottom: 30px'>
    @foreach ($lines as $line)
    <div class='line'>
        <img src="/img/svg/right-chevron.svg" />
        <span>{{ $line }}</span>
    </div>
    @endforeach
</div>

<center class='more-button' style="width: 100%; margin-bottom: 50px" id='service-list-button'>
    <button class="btn-border" onclick="$('#service-list-button').remove(); $('.service-list').show(0)">
        дополнительные услуги
    </button>
</center>

<style>
    .service-list {
        display: none;
    }
    .banner-block {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .service-list__items {
        border-top: 1px solid #c7c7c7;
        padding-top: 30px;
    }
</style>
