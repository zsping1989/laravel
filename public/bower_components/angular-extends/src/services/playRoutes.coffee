'use strict'

angular.module 'ngExtends.services.playRoutes', []

.provider '$playRoutes', [->
  @jsRoutes = window.Routes
  @$get = [
    '$http', '$location'
    ($http, $location) =>
      wrapHttp = (fn) -> ->
        routeObject = fn.apply(@, arguments)
        httpMethod = routeObject.method.toLowerCase()
        absoluteURL = routeObject.absoluteURL()
        host = absoluteURL.match(/^https?:\/\/([^\/?#]+)(?:[\/?#]|$)/i)?[1]
        url = if $location.host() is host then routeObject.url else absoluteURL
        res =
          $route: routeObject
          method: httpMethod
          url: url
          absoluteURL: routeObject.absoluteURL
          webSocketURL: routeObject.webSocketURL
        res.send = res.ajax = (options) ->
          options = options or {}
          options.method = httpMethod
          options.url = url
          $http(options)
        res[httpMethod] = (args...) ->
          (ajax = $http[httpMethod]).apply(ajax, [].concat.call([url], args))
        res

      (addRoutes = (playRoutesObject, jsRoutesObject) ->
        for key, value of jsRoutesObject
          if angular.isFunction value
            playRoutesObject[key] = wrapHttp(value)
          else
            playRoutesObject[key] = {}  unless key of playRoutesObject
            addRoutes(playRoutesObject[key], value)
        return
      )(playRoutes = {}, @jsRoutes)
      playRoutes
  ]
  return
]