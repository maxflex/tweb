<div ng-click="service.next()">
    <img ng-src='@{{ item.url }}' class="gallery-photo pointer">
</div>
<div class="gallery-header">
    @{{ item.name }}
    <span ng-if='item.days_to_complete'>– <plural count="item.days_to_complete" type='day'></plural></span>
</div>
<div>
    @{{ item.description }}
</div>
