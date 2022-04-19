<div>
    <img ng-src='@{{ item.thumb }}' class="gallery-photo pointer" alt="@{{ altt }}">
</div>
<div>
    <div class="entity-header header-3 gallery-preview-header">
        @{{ item.name }}
        <span class="address-gallery-remove">
            –
            <plural count="item.days_to_complete" type='day'></plural>
            <a class="gallery link-small pointer">подробнее...</a>
        </span>
    </div>
</div>
