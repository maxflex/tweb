<div class="common footer-links">
    @foreach ($pages as $page)
        <a href="/{{ $page->url }}">{{ $page->keyphrase }}</a>
    @endforeach
</div>
