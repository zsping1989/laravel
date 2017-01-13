'use strict'

angular.module 'ngExtends.directives.lower', []

.directive 'exLower', [->
  require: 'ngModel'
  link: (scope, element, attrs, modelCtrl) ->
    toLower = (inputValue) ->
      lowered = if inputValue then inputValue.toLowerCase() else inputValue
      unless lowered is inputValue
        elem = element[0]
        start = elem.selectionStart
        end = elem.selectionEnd
        modelCtrl.$setViewValue lowered
        modelCtrl.$render()
        elem.setSelectionRange?(start, end)
      lowered

    modelCtrl.$parsers.push toLower
    toLower scope[attrs.ngModel]
    return
]
