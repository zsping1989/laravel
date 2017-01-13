'use strict'

angular.module 'ngExtends.directives.domInit', []

.directive 'exDomInit', [->
  restrict: 'A',
  link: (scope, element, attrs) ->
    attrs.$observe 'exDomInit', (value) -> scope.$eval(value)?(element)
    return
]