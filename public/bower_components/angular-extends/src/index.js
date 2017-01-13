'use strict';

import './directives/countTo.coffee'
import './directives/domInit.coffee'
import './directives/focusMe.coffee'
import './directives/lower.coffee'
import './directives/repeatDone.coffee'
import './directives/rotate2d.coffee'
import './directives/upper.coffee'
import './filters/arrays.coffee'
import './filters/strings.coffee'
import './services/playRoutes.coffee'
import './services/searchForm.coffee'

angular.module('ngExtends.directives', [
    'ngExtends.directives.countTo',
    'ngExtends.directives.domInit',
    'ngExtends.directives.focusMe',
    'ngExtends.directives.lower',
    'ngExtends.directives.repeatDone',
    'ngExtends.directives.rotate2d',
    'ngExtends.directives.upper'
]);

angular.module('ngExtends.filters', [
    'ngExtends.filters.arrays',
    'ngExtends.filters.strings'
]);

angular.module('ngExtends.services', [
    'ngExtends.services.playRoutes',
    'ngExtends.services.searchForm'
]);

angular.module('ngExtends', [
    'ngExtends.directives',
    'ngExtends.filters',
    'ngExtends.services'
]);
