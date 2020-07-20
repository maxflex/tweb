<div class="common footer-links">
    @foreach ($pages as $index => $page)
        <a @if($index > 10) class="to-toggle hidden"  @endif href="/{{ $page->url }}">{{ $page->keyphrase }}</a>
    @endforeach
    @if(count($pages) > 11)
    <center class="more-button">
        <button class="btn-border" onclick="toggleFooterLinks()">показать ещё</button>
    </center>
    @endif
</div>
