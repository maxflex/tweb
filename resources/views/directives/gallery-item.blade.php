<div>
    <img ng-click="service.open(index)" ng-src='@{{ item.thumb }}' class="gallery-photo pointer">
</div>
<div>
    <div class="entity-header header-3">
        @{{ item.name }} – <plural count="item.days_to_complete" type='day'></plural>
        <a ng-click="service.open(index)" class="link-small pointer">подробнее...</a>
    </div>
</div>
