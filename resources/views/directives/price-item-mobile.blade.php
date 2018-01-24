<div class="price-line price-@{{ item.is_section ? 'section' : 'position' }}"
    ng-click="toggle(item, $event)" ng-class="{'pointer': item.items && item.items.length}">
    <span class="price-line-title" ng-style="getStyle()">@{{ item.model.name }}</span>
    <span ng-show="!item.is_section && item.model.price" class="price-item-info" ng-style="getStyle()">
        от <span class="price-item-price">@{{ priceRounded(item.model.price) | number }}</span> руб.<span ng-show="item.model.unit">/@{{ findById(Units, item.model.unit).title }}</span>
    </span>
    <span ng-show="item.is_section && item.model.extra_column" class="price-section-desc" ng-style="getStyle()">
        @{{ item.model.extra_column }}
    </span>
    <img ng-if="item.is_section && (item.items && item.items.length)" src="/img/svg/pricelist-arrow.svg">
</div>
<ul class="hidden">
    <li ng-repeat="item in item.items" class="price-item-@{{ $parent.$id }} price-item-@{{ item.is_section ? 'section' : 'position' }}">
        <price-item item='item' level="level + 1" ng-class="level-@{{ level }}"></price-item>
    </li>
</ul>