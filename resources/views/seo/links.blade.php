<div class="common footer-links address-footer-links">
    @foreach ($pages as $index => $page)
        <a @if($index >= 3) class="hidden"  @endif href="/{{ $page->url }}">{{ $page->keyphrase }}</a>
    @endforeach
    <a class="pointer" onclick="$('.address-footer-links > a').removeClass('hidden'); $(this).remove()">Показать ещё...</a>
</div>
