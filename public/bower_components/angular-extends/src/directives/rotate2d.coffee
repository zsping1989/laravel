'use strict'

angular.module 'ngExtends.directives.rotate2d', []

.directive 'exRotate2d', [->
  scope:
    value: '=exRotate2d'
    limit: '='
    angle: '='
  link: (scope, element) ->
    scope.$watchCollection '[value, limit, angle]', (values) ->
      value = values[0] or 0
      limit = values[1] or 10
      angle = values[2] or 360
      degree = value * angle / limit
      element.css
        '-webkit-transform': 'rotate(' + degree + 'deg)'
        '-moz-transform': 'rotate(' + degree + 'deg)'
        'transform': 'rotate(' + degree + 'deg)'
      return
    return
]