/**
 * Created by zhang on 16-5-18.
 */
define(['app'], function (app) {
    app.register.controller('home-public-headerCtrl', ["$scope", '$rootScope','View','$alert', function ($scope,$rootScope,View,$alert) {
        var data = {'hash':parseURL('hash')};
        dump(data);
        $scope = View.with(data,$scope);
    }]);
})