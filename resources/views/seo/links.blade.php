<div class="common footer-links address-footer-links">
    @foreach ($pages as $index => $page)
        <a @if($index > 10) class="hidden"  @endif href="/{{ $page->url }}">{{ $page->keyphrase }}</a>
    @endforeach
    <center class="more-button">
        <button class="btn-border" onclick="toggleFooterLinks()">показать ещё</button>
    </center>
</div>
