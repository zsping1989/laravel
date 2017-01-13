'use strict'

angular.module 'ngExtends.directives.upper', []

.directive 'exUpper', [->
  require: 'ngModel'
  link: (scope, element, attrs, modelCtrl) ->
    toUpper = (inputValue) ->
      uppered = if inputValue then inputValue.toUpperCase() else inputValue
      unless uppered is inputValue
        elem = element[0]
        start = elem.selectionStart
        end = elem.selectionEnd
        modelCtrl.$setViewValue uppered
        modelCtrl.$render()
        elem.setSelectionRange?(start, end)
      uppered

    modelCtrl.$parsers.push toUpper
    toUpper scope[attrs.ngModel]
    return
]
