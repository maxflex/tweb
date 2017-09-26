<div class="price-line" ng-click="toggle(item, $event)" ng-class="{
    'price-section': item.is_section,
    'pointer': item.items && item.items.length
}">
    <span class="price-line-title">@{{ item.model.name }}</span>
    <span ng-show="!item.is_section && item.model.price" class="price-item-info">
        <span class="price-item-price">@{{ item.model.price | number }}</span> руб.<span ng-show="item.model.unit">/@{{ findById(Units, item.model.unit).title }}</span>
    </span>
    <i ng-if="item.is_section && (item.items && item.items.length)" class="fa fa-caret-down pull-right" aria-hidden="true"></i>
</div>
<ul class="hidden">
    <li ng-repeat="item in item.items" class='price-item-@{{ $parent.$id }}'>
        <price-item item='item'></price-item>
    </li>
</ul>
