'use strict'

angular.module 'ngExtends.services.searchForm', []

.factory '$searchForm', [-> (options) ->

  class SearchForm
    constructor: (@options) ->
      if angular.isFunction @options
        @options = action: @options
      @options = angular.extend(
        defaults: {}
        preSubmit: (form, filters, unfilters) ->
        preReset: (form) ->
        submit: (form, filters, unfilters) ->
        reset: (form) ->
        action: (form) ->
        #transform: (key, value) -> value
      , @options)

      @current = angular.copy(@options.defaults) or {}
      @form = angular.copy(@options.defaults) or {}

    isPristine: -> angular.equals(@current, @form)
    isDirty: -> not @isPristine()
    isChanged: -> not angular.equals(@current, @options.defaults)

    submit: (form, filters, unfilters) ->
      if @options.preSubmit?(form, filters, unfilters) isnt false
        if filters?
          isFiltered = ([key, value]  for key, value of filters or {}).every (keyWithValue) =>
            [key, value] = keyWithValue
            angular.equals(@form[key], value, true)
          angular.extend(@form, angular.copy(if isFiltered then unfilters else filters))
        @current = angular.copy(@form)
        @options.submit?(form, filters, unfilters)
        @options.action?(form)
      @

    reset: (form) ->
      if @options.preReset?(form) isnt false
        form?.$setPristine?()
        @current = angular.copy(@options.defaults) or {}
        @form = angular.copy(@options.defaults) or {}
        @options.reset?(form)
        @options.action?(form)
      @

    params: (refresh, defaults) ->
      [defaults, refresh] = [refresh, false]  if angular.isObject refresh

      params = if refresh is true
        angular.copy(@current)
      else
        angular.copy(@form = angular.copy(@current))

      for key of @options.defaults
        params[key] = params[key].filter((a) -> !!a)  if angular.isArray params[key]

      params = angular.extend params, angular.copy(defaults)

      if angular.isFunction @options.transform
        params[key] = @options.transform(key, value)  for key, value of params

      params

  new SearchForm(options)
]
