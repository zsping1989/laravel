'use strict'

angular.module 'ngExtends.filters.strings', []

.filter 'trustAs', ['$sce', ($sce) -> (input, type) -> $sce.trustAs(type, input)]
.filter 'trustAsCss', ['$sce', ($sce) -> $sce.trustAsCss]
.filter 'trustAsHtml', ['$sce', ($sce) -> $sce.trustAsHtml]
.filter 'trustAsJs', ['$sce', ($sce) -> $sce.trustAsJs]
.filter 'trustAsResourceUrl', ['$sce', ($sce) -> $sce.trustAsResourceUrl]
.filter 'trustAsUrl', ['$sce', ($sce) -> $sce.trustAsUrl]

.filter 'replace', [-> (input, search, replacement, options) ->
  search = new RegExp((search or '').toString(), options)  unless search instanceof RegExp
  (input or '').toString().replace(search, replacement)
]

.filter 'nl2br', [-> (input) -> (input or '').toString().replace(/(\r\n|\n\r|\r|\n)/g, '<br/>')]

.filter 'br2nl', [-> (input) -> (input or '').toString().replace(/(<br>|<br\/>)/g, '\n')]

.filter 'space2nbsp', [-> (input) -> (input or '').toString().replace(/\s/g, '&nbsp;')]

.filter 'nbsp2space', [-> (input) -> (input or '').toString().replace(/&nbsp;/g, ' ')]

.filter 'split', [-> (input, separators, limit) ->
  unless input? then input
  else input.toString().split(new RegExp(
    (if angular.isArray separators then separators.join('|') else separators).toString()
  ), limit)
]

.filter 'cutstring', [-> (input, maxLength = 10, suffix = '...') ->
  unless input? then input
  else
    inputString = input.toString()
    inputString = inputString[0...maxLength] + suffix  if inputString.length > maxLength - suffix.length
    inputString
]

.filter 'roundcutstring', [-> (input, search, maxLength = 20, prefix = '...', suffix = '...') ->
  unless input? then input
  else
    inputString = input.toString()
    searchString = (search or '').toString()
    i = inputString.indexOf(searchString)
    if i is -1
      inputString = inputString[0...maxLength] + suffix  if inputString.length > maxLength - suffix.length
      inputString
    else
      (doCut = (before, after, string, restLength) ->
        if restLength <= 0 or before.length is 0 and after.length is 0
          emptyOrPrefix = if before.length > 0 then prefix else ''
          emptyOrSuffix = if after.length > 0 then suffix else ''
          emptyOrPrefix + string + emptyOrSuffix
        else
          halfLength = restLength / 2
          if halfLength < 1
            doCut(before[0...-1], after, before[-1...] + string, 0)
          else
            pieceOfBefore = before[-halfLength...]
            pieceOfAfter = after[0...halfLength]
            restOfBefore = before[0...-halfLength]
            restOfAfter = after[halfLength...]
            doCut(
              restOfBefore,
              restOfAfter,
              pieceOfBefore + string + pieceOfAfter,
              restLength - pieceOfBefore.length - pieceOfAfter.length
            )
      )(
        inputString[0...i],
        inputString[i + searchString.length...],
        searchString,
        maxLength - searchString.length - prefix.length - suffix.length
      )
]