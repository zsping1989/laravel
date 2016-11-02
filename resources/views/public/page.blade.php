<ul class="pagination" style="margin-top: 0px;">
    <li ng-class="{disabled:current_page==1}">
        <a ng-click="getData($this,{'page':current_page-1})" aria-label="Previous"><span aria-hidden="true">«</span></a>
    </li>
    <li ng-show="current_page>4 || total==0"  ng-class="{active:total==0}"><a ng-click="getData($this,{'page':1})">1</a></li>
    <li ng-repeat="i in [-3,-2,-1,0,1,2,3]" ng-show="current_page+i>0 && current_page+i<=last_page" ng-class="{active:i==0}">
        <a ng-click="getData($this,{'page':current_page+i})">@{{current_page+i}}</a>
    </li>
    <li ng-show="current_page<last_page-3"><a ng-click="getData($this,{'page':last_page})">@{{last_page}}</a></li>
    <li ng-class="{disabled:(current_page==last_page||last_page==0)}">
        <a aria-label="Next" ng-click="getData($this,{'page':current_page+1})"><span aria-hidden="true">»</span></a>
    </li>
</ul>