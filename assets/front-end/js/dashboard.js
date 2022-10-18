/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
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
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/dashboard.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/dashboard.js":
/*!*****************************!*\
  !*** ./src/js/dashboard.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
eval("\n\n!function (c, d) {\n  c(function () {\n    var a = c(\".ts-dashboard-tabs\"),\n        e = a.find(\".ts-dashboard-tabs__nav\"),\n        i = a.find(\".ts-dashboard-tabs__content\"),\n        //s = c(\"#toplevel_page_happy-addons\").find(\".wp-submenu\"),\n    t = (e.on(\"click\", \".ts-dashboard-tabs__nav-item\", function (a) {\n      var e = c(a.currentTarget),\n          t = a.currentTarget.hash,\n          n = \"#tab-content-\" + t.substring(1),\n          n = i.find(n);\n      if (e.is(\".nav-item-is--link\")) return !0;\n      a.preventDefault(), e.addClass(\"tab--is-active\").siblings().removeClass(\"tab--is-active\"), n.addClass(\"tab--is-active\").siblings().removeClass(\"tab--is-active\"), window.location.hash = t, s.find(\"a\").filter(function (a, e) {\n        return t === e.hash;\n      }).parent().addClass(\"current\").siblings().removeClass(\"current\");\n    }), window.location.hash && (e.find('a[href=\"' + window.location.hash + '\"]').click(), s.find(\"a\").filter(function (a, e) {\n      return window.location.hash === e.hash;\n    }).parent().addClass(\"current\").siblings().removeClass(\"current\")), s.on(\"click\", \"a\", function (a) {\n      return !a.currentTarget.hash || (a.preventDefault(), window.location.hash = a.currentTarget.hash, c(a.currentTarget).parent().addClass(\"current\").siblings().removeClass(\"current\"), void e.find('a[href=\"' + a.currentTarget.hash + '\"]').click());\n    })),\n        o = t.find(\".ts-dashboard-widgets\"),\n        n = t.find(\".ts-dashboard-btn--save\");\n  });\n}(jQuery, window.HappyDashboard);\n\n//# sourceURL=webpack:///./src/js/dashboard.js?");

/***/ })

/******/ });