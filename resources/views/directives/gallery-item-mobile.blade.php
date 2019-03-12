<div>
    <img id="p-@{{ index }}" ng-click="service.open(index)" ng-src='@{{ item.url }}'  class="gallery-photo">
</div>
<div>
    <b>
        @{{ item.name }}
        <span ng-if="item.days_to_complete">– <plural count="item.days_to_complete" type='day'></plural></span>
    </b>
</div>
