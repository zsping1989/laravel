(function webpackUniversalModuleDefinition(root, factory) {
	if(typeof exports === 'object' && typeof module === 'object')
		module.exports = factory(require("angular"));
	else if(typeof define === 'function' && define.amd)
		define(["angular"], factory);
	else {
		var a = typeof exports === 'object' ? factory(require("angular")) : factory(root["angular"]);
		for(var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
	}
})(this, function(__WEBPACK_EXTERNAL_MODULE_2__) {
return /******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	
	__webpack_require__(3);
	
	__webpack_require__(4);
	
	__webpack_require__(5);
	
	__webpack_require__(6);
	
	__webpack_require__(7);
	
	__webpack_require__(8);
	
	__webpack_require__(9);
	
	__webpack_require__(10);
	
	__webpack_require__(11);
	
	__webpack_require__(12);
	
	__webpack_require__(14);
	
	angular.module('ngExtends.directives', ['ngExtends.directives.countTo', 'ngExtends.directives.domInit', 'ngExtends.directives.focusMe', 'ngExtends.directives.lower', 'ngExtends.directives.repeatDone', 'ngExtends.directives.rotate2d', 'ngExtends.directives.upper']);
	
	angular.module('ngExtends.filters', ['ngExtends.filters.arrays', 'ngExtends.filters.strings']);
	
	angular.module('ngExtends.services', ['ngExtends.services.playRoutes', 'ngExtends.services.searchForm']);
	
	angular.module('ngExtends', ['ngExtends.directives', 'ngExtends.filters', 'ngExtends.services']);
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';
	
	var _angular = __webpack_require__(2);
	
	var _angular2 = _interopRequireDefault(_angular);
	
	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }
	
	if (!_angular2.default) {
	    throw new Error("Angular.extends requires a AngularJS");
	}
	
	module.exports = _angular2.default;

/***/ },
/* 2 */
/***/ function(module, exports) {

	module.exports = __WEBPACK_EXTERNAL_MODULE_2__;

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.countTo', []).directive('exCountTo', [
	  '$timeout', function($timeout) {
	    return {
	      replace: false,
	      scope: true,
	      link: function(scope, element, attrs) {
	        var calculate, countTo, elem, increment, num, refreshInterval, start, step, steps, tick;
	        elem = element[0];
	        num = null;
	        refreshInterval = null;
	        steps = null;
	        step = null;
	        countTo = null;
	        increment = null;
	        calculate = function() {
	          var duration;
	          refreshInterval = 30;
	          step = 0;
	          scope.timoutId = null;
	          countTo = parseInt(attrs.exCountTo) || 0;
	          scope.value = parseInt(attrs.value, 10) || 0;
	          duration = (parseFloat(attrs.duration) * 1000) || 0;
	          steps = Math.ceil(duration / refreshInterval);
	          increment = (countTo - scope.value) / steps;
	          num = scope.value;
	        };
	        tick = function() {
	          scope.timoutId = $timeout(function() {
	            num += increment;
	            step++;
	            if (step >= steps) {
	              $timeout.cancel(scope.timoutId);
	              num = countTo;
	              return elem.textContent = countTo;
	            } else {
	              elem.textContent = Math.round(num);
	              return tick();
	            }
	          }, refreshInterval);
	        };
	        start = function() {
	          if (scope.timoutId != null) {
	            $timeout.cancel(scope.timoutId);
	          }
	          calculate();
	          tick();
	        };
	        attrs.$observe('exCountTo', function(val) {
	          if (val != null) {
	            return start();
	          }
	        });
	        attrs.$observe('value', function() {
	          return start();
	        });
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.domInit', []).directive('exDomInit', [
	  function() {
	    return {
	      restrict: 'A',
	      link: function(scope, element, attrs) {
	        attrs.$observe('exDomInit', function(value) {
	          var base;
	          return typeof (base = scope.$eval(value)) === "function" ? base(element) : void 0;
	        });
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 5 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.focusMe', []).directive('exFocusMe', [
	  function() {
	    return {
	      scope: {
	        trigger: '=exFocusMe'
	      },
	      link: function(scope, element) {
	        scope.$watch('trigger', function(value) {
	          var base, name;
	          if (typeof value === 'boolean') {
	            if (typeof (base = element[0])[name = value ? 'focus' : 'blur'] === "function") {
	              base[name]();
	            }
	            scope.trigger = null;
	          }
	        });
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 6 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.lower', []).directive('exLower', [
	  function() {
	    return {
	      require: 'ngModel',
	      link: function(scope, element, attrs, modelCtrl) {
	        var toLower;
	        toLower = function(inputValue) {
	          var elem, end, lowered, start;
	          lowered = inputValue ? inputValue.toLowerCase() : inputValue;
	          if (lowered !== inputValue) {
	            elem = element[0];
	            start = elem.selectionStart;
	            end = elem.selectionEnd;
	            modelCtrl.$setViewValue(lowered);
	            modelCtrl.$render();
	            if (typeof elem.setSelectionRange === "function") {
	              elem.setSelectionRange(start, end);
	            }
	          }
	          return lowered;
	        };
	        modelCtrl.$parsers.push(toLower);
	        toLower(scope[attrs.ngModel]);
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.repeatDone', []).directive('exRepeatDone', [
	  function() {
	    return {
	      restrict: 'A',
	      link: function(scope, element, attrs) {
	        if (((attrs.ngRepeat != null) || (attrs.ngRepeatStart != null)) && scope.$last) {
	          attrs.$observe('exRepeatDone', function(value) {
	            var base;
	            return typeof (base = scope.$eval(value)) === "function" ? base(element) : void 0;
	          });
	        }
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.rotate2d', []).directive('exRotate2d', [
	  function() {
	    return {
	      scope: {
	        value: '=exRotate2d',
	        limit: '=',
	        angle: '='
	      },
	      link: function(scope, element) {
	        scope.$watchCollection('[value, limit, angle]', function(values) {
	          var angle, degree, limit, value;
	          value = values[0] || 0;
	          limit = values[1] || 10;
	          angle = values[2] || 360;
	          degree = value * angle / limit;
	          element.css({
	            '-webkit-transform': 'rotate(' + degree + 'deg)',
	            '-moz-transform': 'rotate(' + degree + 'deg)',
	            'transform': 'rotate(' + degree + 'deg)'
	          });
	        });
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.directives.upper', []).directive('exUpper', [
	  function() {
	    return {
	      require: 'ngModel',
	      link: function(scope, element, attrs, modelCtrl) {
	        var toUpper;
	        toUpper = function(inputValue) {
	          var elem, end, start, uppered;
	          uppered = inputValue ? inputValue.toUpperCase() : inputValue;
	          if (uppered !== inputValue) {
	            elem = element[0];
	            start = elem.selectionStart;
	            end = elem.selectionEnd;
	            modelCtrl.$setViewValue(uppered);
	            modelCtrl.$render();
	            if (typeof elem.setSelectionRange === "function") {
	              elem.setSelectionRange(start, end);
	            }
	          }
	          return uppered;
	        };
	        modelCtrl.$parsers.push(toUpper);
	        toUpper(scope[attrs.ngModel]);
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 10 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	var slice = [].slice;
	
	angular.module('ngExtends.filters.arrays', []).filter('makeArray', [
	  function() {
	    return function(input) {
	      if (angular.isArray(input)) {
	        return input;
	      } else if (input == null) {
	        return [];
	      } else {
	        return [input];
	      }
	    };
	  }
	]).filter('range', [
	  function() {
	    return function(from, to, step) {
	      var begin, end, i, isNumber, j, ref, ref1, ref2, results;
	      if (step == null) {
	        step = 1;
	      }
	      isNumber = typeof from === 'number' && typeof to === 'number';
	      begin = isNumber ? from : from.toString().charCodeAt(0);
	      end = isNumber ? to : to.toString().charCodeAt(0);
	      results = [];
	      for (i = j = ref = begin, ref1 = end, ref2 = (begin > end ? -step : step); ref2 > 0 ? j <= ref1 : j >= ref1; i = j += ref2) {
	        if (isNumber) {
	          results.push(i);
	        } else {
	          results.push(String.fromCharCode(i));
	        }
	      }
	      return results;
	    };
	  }
	]).filter('join', [
	  'makeArrayFilter', function(makeArrayFilter) {
	    return function(input, sep) {
	      return makeArrayFilter(input).join(sep);
	    };
	  }
	]).filter('combine', [
	  '$parse', function($parse) {
	    return function() {
	      var input, t, transformers, value;
	      input = arguments[0], transformers = 2 <= arguments.length ? slice.call(arguments, 1) : [];
	      if (!angular.isArray(input)) {
	        input = [input];
	      }
	      return ((function() {
	        var j, k, len, len1, results;
	        results = [];
	        for (j = 0, len = input.length; j < len; j++) {
	          value = input[j];
	          for (k = 0, len1 = transformers.length; k < len1; k++) {
	            t = transformers[k];
	            if (angular.isFunction(t)) {
	              value = t(value);
	            } else if (typeof t === 'string') {
	              value = (function() {
	                switch (t) {
	                  case '=integer':
	                    return parseInt(value);
	                  case '=float':
	                    return parseFloat(value);
	                  default:
	                    return $parse(t)(value);
	                }
	              })();
	            }
	          }
	          results.push(value);
	        }
	        return results;
	      })()).reduce(function(t, v) {
	        return t + v;
	      });
	    };
	  }
	]).filter('limit', [
	  'makeArrayFilter', function(makeArrayFilter) {
	    return function(input, page, itemsPerPage) {
	      var from, to;
	      from = (page - 1) * itemsPerPage;
	      to = from + itemsPerPage;
	      return makeArrayFilter(input).slice(from, to);
	    };
	  }
	]).filter('trim', [
	  function() {
	    return function(input) {
	      var a, j, len, ref, ref1, results;
	      if (angular.isArray(input)) {
	        results = [];
	        for (j = 0, len = input.length; j < len; j++) {
	          a = input[j];
	          results.push(a != null ? typeof a.toString === "function" ? (ref = a.toString()) != null ? typeof ref.trim === "function" ? ref.trim() : void 0 : void 0 : void 0 : void 0);
	        }
	        return results;
	      } else {
	        return input != null ? typeof input.toString === "function" ? (ref1 = input.toString()) != null ? typeof ref1.trim === "function" ? ref1.trim() : void 0 : void 0 : void 0 : void 0;
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 11 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.filters.strings', []).filter('trustAs', [
	  '$sce', function($sce) {
	    return function(input, type) {
	      return $sce.trustAs(type, input);
	    };
	  }
	]).filter('trustAsCss', [
	  '$sce', function($sce) {
	    return $sce.trustAsCss;
	  }
	]).filter('trustAsHtml', [
	  '$sce', function($sce) {
	    return $sce.trustAsHtml;
	  }
	]).filter('trustAsJs', [
	  '$sce', function($sce) {
	    return $sce.trustAsJs;
	  }
	]).filter('trustAsResourceUrl', [
	  '$sce', function($sce) {
	    return $sce.trustAsResourceUrl;
	  }
	]).filter('trustAsUrl', [
	  '$sce', function($sce) {
	    return $sce.trustAsUrl;
	  }
	]).filter('replace', [
	  function() {
	    return function(input, search, replacement, options) {
	      if (!(search instanceof RegExp)) {
	        search = new RegExp((search || '').toString(), options);
	      }
	      return (input || '').toString().replace(search, replacement);
	    };
	  }
	]).filter('nl2br', [
	  function() {
	    return function(input) {
	      return (input || '').toString().replace(/(\r\n|\n\r|\r|\n)/g, '<br/>');
	    };
	  }
	]).filter('br2nl', [
	  function() {
	    return function(input) {
	      return (input || '').toString().replace(/(<br>|<br\/>)/g, '\n');
	    };
	  }
	]).filter('space2nbsp', [
	  function() {
	    return function(input) {
	      return (input || '').toString().replace(/\s/g, '&nbsp;');
	    };
	  }
	]).filter('nbsp2space', [
	  function() {
	    return function(input) {
	      return (input || '').toString().replace(/&nbsp;/g, ' ');
	    };
	  }
	]).filter('split', [
	  function() {
	    return function(input, separators, limit) {
	      if (input == null) {
	        return input;
	      } else {
	        return input.toString().split(new RegExp((angular.isArray(separators) ? separators.join('|') : separators).toString()), limit);
	      }
	    };
	  }
	]).filter('cutstring', [
	  function() {
	    return function(input, maxLength, suffix) {
	      var inputString;
	      if (maxLength == null) {
	        maxLength = 10;
	      }
	      if (suffix == null) {
	        suffix = '...';
	      }
	      if (input == null) {
	        return input;
	      } else {
	        inputString = input.toString();
	        if (inputString.length > maxLength - suffix.length) {
	          inputString = inputString.slice(0, maxLength) + suffix;
	        }
	        return inputString;
	      }
	    };
	  }
	]).filter('roundcutstring', [
	  function() {
	    return function(input, search, maxLength, prefix, suffix) {
	      var doCut, i, inputString, searchString;
	      if (maxLength == null) {
	        maxLength = 20;
	      }
	      if (prefix == null) {
	        prefix = '...';
	      }
	      if (suffix == null) {
	        suffix = '...';
	      }
	      if (input == null) {
	        return input;
	      } else {
	        inputString = input.toString();
	        searchString = (search || '').toString();
	        i = inputString.indexOf(searchString);
	        if (i === -1) {
	          if (inputString.length > maxLength - suffix.length) {
	            inputString = inputString.slice(0, maxLength) + suffix;
	          }
	          return inputString;
	        } else {
	          return (doCut = function(before, after, string, restLength) {
	            var emptyOrPrefix, emptyOrSuffix, halfLength, pieceOfAfter, pieceOfBefore, restOfAfter, restOfBefore;
	            if (restLength <= 0 || before.length === 0 && after.length === 0) {
	              emptyOrPrefix = before.length > 0 ? prefix : '';
	              emptyOrSuffix = after.length > 0 ? suffix : '';
	              return emptyOrPrefix + string + emptyOrSuffix;
	            } else {
	              halfLength = restLength / 2;
	              if (halfLength < 1) {
	                return doCut(before.slice(0, -1), after, before.slice(-1) + string, 0);
	              } else {
	                pieceOfBefore = before.slice(-halfLength);
	                pieceOfAfter = after.slice(0, halfLength);
	                restOfBefore = before.slice(0, -halfLength);
	                restOfAfter = after.slice(halfLength);
	                return doCut(restOfBefore, restOfAfter, pieceOfBefore + string + pieceOfAfter, restLength - pieceOfBefore.length - pieceOfAfter.length);
	              }
	            }
	          })(inputString.slice(0, i), inputString.slice(i + searchString.length), searchString, maxLength - searchString.length - prefix.length - suffix.length);
	        }
	      }
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ },
/* 12 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular, window) {'use strict';
	var slice = [].slice;
	
	angular.module('ngExtends.services.playRoutes', []).provider('$playRoutes', [
	  function() {
	    this.jsRoutes = window.Routes;
	    this.$get = [
	      '$http', '$location', (function(_this) {
	        return function($http, $location) {
	          var addRoutes, playRoutes, wrapHttp;
	          wrapHttp = function(fn) {
	            return function() {
	              var absoluteURL, host, httpMethod, ref, res, routeObject, url;
	              routeObject = fn.apply(this, arguments);
	              httpMethod = routeObject.method.toLowerCase();
	              absoluteURL = routeObject.absoluteURL();
	              host = (ref = absoluteURL.match(/^https?:\/\/([^\/?#]+)(?:[\/?#]|$)/i)) != null ? ref[1] : void 0;
	              url = $location.host() === host ? routeObject.url : absoluteURL;
	              res = {
	                $route: routeObject,
	                method: httpMethod,
	                url: url,
	                absoluteURL: routeObject.absoluteURL,
	                webSocketURL: routeObject.webSocketURL
	              };
	              res.send = res.ajax = function(options) {
	                options = options || {};
	                options.method = httpMethod;
	                options.url = url;
	                return $http(options);
	              };
	              res[httpMethod] = function() {
	                var ajax, args;
	                args = 1 <= arguments.length ? slice.call(arguments, 0) : [];
	                return (ajax = $http[httpMethod]).apply(ajax, [].concat.call([url], args));
	              };
	              return res;
	            };
	          };
	          (addRoutes = function(playRoutesObject, jsRoutesObject) {
	            var key, value;
	            for (key in jsRoutesObject) {
	              value = jsRoutesObject[key];
	              if (angular.isFunction(value)) {
	                playRoutesObject[key] = wrapHttp(value);
	              } else {
	                if (!(key in playRoutesObject)) {
	                  playRoutesObject[key] = {};
	                }
	                addRoutes(playRoutesObject[key], value);
	              }
	            }
	          })(playRoutes = {}, _this.jsRoutes);
	          return playRoutes;
	        };
	      })(this)
	    ];
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1), __webpack_require__(13)))

/***/ },
/* 13 */
/***/ function(module, exports) {

	/* WEBPACK VAR INJECTION */(function(global) {'use strict';
	
	if (!global.document) {
	    throw new Error("Angular.extends requires a window with a document");
	}
	
	module.exports = global;
	/* WEBPACK VAR INJECTION */}.call(exports, (function() { return this; }())))

/***/ },
/* 14 */
/***/ function(module, exports, __webpack_require__) {

	/* WEBPACK VAR INJECTION */(function(angular) {'use strict';
	angular.module('ngExtends.services.searchForm', []).factory('$searchForm', [
	  function() {
	    return function(options) {
	      var SearchForm;
	      SearchForm = (function() {
	        function SearchForm(options1) {
	          this.options = options1;
	          if (angular.isFunction(this.options)) {
	            this.options = {
	              action: this.options
	            };
	          }
	          this.options = angular.extend({
	            defaults: {},
	            preSubmit: function(form, filters, unfilters) {},
	            preReset: function(form) {},
	            submit: function(form, filters, unfilters) {},
	            reset: function(form) {},
	            action: function(form) {}
	          }, this.options);
	          this.current = angular.copy(this.options.defaults) || {};
	          this.form = angular.copy(this.options.defaults) || {};
	        }
	
	        SearchForm.prototype.isPristine = function() {
	          return angular.equals(this.current, this.form);
	        };
	
	        SearchForm.prototype.isDirty = function() {
	          return !this.isPristine();
	        };
	
	        SearchForm.prototype.isChanged = function() {
	          return !angular.equals(this.current, this.options.defaults);
	        };
	
	        SearchForm.prototype.submit = function(form, filters, unfilters) {
	          var base, base1, base2, isFiltered, key, value;
	          if ((typeof (base = this.options).preSubmit === "function" ? base.preSubmit(form, filters, unfilters) : void 0) !== false) {
	            if (filters != null) {
	              isFiltered = ((function() {
	                var ref, results;
	                ref = filters || {};
	                results = [];
	                for (key in ref) {
	                  value = ref[key];
	                  results.push([key, value]);
	                }
	                return results;
	              })()).every((function(_this) {
	                return function(keyWithValue) {
	                  var key, value;
	                  key = keyWithValue[0], value = keyWithValue[1];
	                  return angular.equals(_this.form[key], value, true);
	                };
	              })(this));
	              angular.extend(this.form, angular.copy(isFiltered ? unfilters : filters));
	            }
	            this.current = angular.copy(this.form);
	            if (typeof (base1 = this.options).submit === "function") {
	              base1.submit(form, filters, unfilters);
	            }
	            if (typeof (base2 = this.options).action === "function") {
	              base2.action(form);
	            }
	          }
	          return this;
	        };
	
	        SearchForm.prototype.reset = function(form) {
	          var base, base1, base2;
	          if ((typeof (base = this.options).preReset === "function" ? base.preReset(form) : void 0) !== false) {
	            if (form != null) {
	              if (typeof form.$setPristine === "function") {
	                form.$setPristine();
	              }
	            }
	            this.current = angular.copy(this.options.defaults) || {};
	            this.form = angular.copy(this.options.defaults) || {};
	            if (typeof (base1 = this.options).reset === "function") {
	              base1.reset(form);
	            }
	            if (typeof (base2 = this.options).action === "function") {
	              base2.action(form);
	            }
	          }
	          return this;
	        };
	
	        SearchForm.prototype.params = function(refresh, defaults) {
	          var key, params, ref, value;
	          if (angular.isObject(refresh)) {
	            ref = [refresh, false], defaults = ref[0], refresh = ref[1];
	          }
	          params = refresh === true ? angular.copy(this.current) : angular.copy(this.form = angular.copy(this.current));
	          for (key in this.options.defaults) {
	            if (angular.isArray(params[key])) {
	              params[key] = params[key].filter(function(a) {
	                return !!a;
	              });
	            }
	          }
	          params = angular.extend(params, angular.copy(defaults));
	          if (angular.isFunction(this.options.transform)) {
	            for (key in params) {
	              value = params[key];
	              params[key] = this.options.transform(key, value);
	            }
	          }
	          return params;
	        };
	
	        return SearchForm;
	
	      })();
	      return new SearchForm(options);
	    };
	  }
	]);
	
	/* WEBPACK VAR INJECTION */}.call(exports, __webpack_require__(1)))

/***/ }
/******/ ])
});
;