<div class="common footer-links" @if($isInAddressFolder) ng-init="seoLinksShow = 10" @endif>
    @foreach ($pages as $index => $page)
        <a @if($isInAddressFolder) ng-hide="{{ $index }} > seoLinksShow" @endif href="{{ $page->full_url }}">{{ $page->keyphrase }}</a>
    @endforeach
    @if(count($pages) > 11 && $isInAddressFolder)
    <center class="more-button" ng-hide="seoLinksShow >= {{ count($pages) }}">
        <button class="btn-border" ng-click="seoLinksShow = seoLinksShow + 11">показать ещё</button>
    </center>
    @endif
</div>
