'use strict'

angular.module 'ngExtends.directives.repeatDone', []

.directive 'exRepeatDone', [->
  restrict: 'A',
  link: (scope, element, attrs) ->
    if (attrs.ngRepeat? or attrs.ngRepeatStart?) and scope.$last
      attrs.$observe 'exRepeatDone', (value) -> scope.$eval(value)?(element)
    return
]