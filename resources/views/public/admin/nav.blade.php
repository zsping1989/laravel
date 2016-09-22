<section class="content-header">
    <h1>
        Data Tables
        <small>advanced tables</small>
    </h1>
    <ol class="breadcrumb">
        <li ng-repeat="row in nav" ng-class="{'active':row.url=='end'}">
            <sapn ng-if="row.url=='end'"><i class="fa" ng-class="row.icons"></i> @{{row.name}}</sapn>
            <a ng-if="row.url!='end'" ng-href="@{{row.url}}"><i class="fa" ng-class="row.icons"></i> @{{row.name}}</a>
        </li>
    </ol>
</section>