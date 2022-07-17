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
/******/ 	return __webpack_require__(__webpack_require__.s = "./src/js/advanced-tabs.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/js/advanced-tabs.js":
/*!*********************************!*\
  !*** ./src/js/advanced-tabs.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("ts.hooks.addAction(\"init\", \"ts\", () => {\n  elementorFrontend.hooks.addAction(\"frontend/element_ready/ts-adv-tabs.default\", function ($scope, $) {\n    const $currentTab = $scope.find('.ts-advance-tabs');\n\n    if (!$currentTab.attr('id')) {\n      return false;\n    }\n\n    const $currentTabId = '#' + $currentTab.attr('id').toString();\n    let hashTag = window.location.hash.substr(1);\n    hashTag = hashTag === 'safari' ? 'ts-safari' : hashTag;\n    var hashLink = false;\n    $($currentTabId + ' > .ts-tabs-nav ul li', $scope).each(function (index) {\n      if (hashTag && $(this).attr(\"id\") == hashTag) {\n        $($currentTabId + ' .ts-tabs-nav > ul li', $scope).removeClass(\"active\").addClass(\"inactive\");\n        $(this).removeClass(\"inactive\").addClass(\"active\");\n        hashLink = true;\n      } else {\n        if ($(this).hasClass(\"active-default\") && !hashLink) {\n          $($currentTabId + ' .ts-tabs-nav > ul li', $scope).removeClass(\"active\").addClass(\"inactive\");\n          $(this).removeClass(\"inactive\").addClass('active');\n        } else {\n          if (index == 0) {\n            if ($currentTab.hasClass('ts-tab-auto-active')) {\n              $(this).removeClass(\"inactive\").addClass(\"active\");\n            }\n          }\n        }\n      }\n    });\n    var hashContent = false;\n    $($currentTabId + ' > .ts-tabs-content > div', $scope).each(function (index) {\n      if (hashTag && $(this).attr(\"id\") == hashTag + '-tab') {\n        $($currentTabId + ' > .ts-tabs-content > div', $scope).removeClass(\"active\");\n        let nestedLink = $(this).closest('.ts-tabs-content').closest('.ts-tab-content-item');\n\n        if (nestedLink.length) {\n          let parentTab = nestedLink.closest('.ts-advance-tabs'),\n              titleID = $(\"#\" + nestedLink.attr(\"id\")),\n              contentID = titleID.data('title-link');\n          parentTab.find(\" > .ts-tabs-nav > ul > li\").removeClass('active');\n          parentTab.find(\" > .ts-tabs-content > div\").removeClass('active');\n          titleID.addClass(\"active\");\n          $(\"#\" + contentID).addClass(\"active\");\n        }\n\n        $(this).removeClass(\"inactive\").addClass(\"active\");\n        hashContent = true;\n      } else {\n        if ($(this).hasClass(\"active-default\") && !hashContent) {\n          $($currentTabId + ' > .ts-tabs-content > div', $scope).removeClass(\"active\");\n          $(this).removeClass(\"inactive\").addClass(\"active\");\n        } else {\n          if (index == 0) {\n            if ($currentTab.hasClass('ts-tab-auto-active')) {\n              $(this).removeClass(\"inactive\").addClass(\"active\");\n            }\n          }\n        }\n      }\n    });\n    $($currentTabId + ' .ts-tabs-nav ul li', $scope).on(\"click\", function (e) {\n      e.preventDefault();\n      var currentTabIndex = $(this).index();\n      var tabsContainer = $(this).closest(\".ts-advance-tabs\");\n      var tabsNav = $(tabsContainer).children(\".ts-tabs-nav\").children(\"ul\").children(\"li\");\n      var tabsContent = $(tabsContainer).children(\".ts-tabs-content\").children(\"div\");\n      $(this).parent(\"li\").addClass(\"active\");\n      $(tabsNav).removeClass(\"active active-default\").addClass(\"inactive\").attr('aria-selected', 'false').attr('aria-expanded', 'false');\n      $(this).addClass(\"active\").removeClass(\"inactive\");\n      $(this).attr(\"aria-selected\", 'true').attr(\"aria-expanded\", 'true');\n      $(tabsContent).removeClass(\"active\").addClass(\"inactive\");\n      $(tabsContent).eq(currentTabIndex).addClass(\"active\").removeClass(\"inactive\");\n      ts.hooks.doAction(\"ts-advanced-tabs-triggered\", $(tabsContent).eq(currentTabIndex));\n      $(tabsContent).each(function (index) {\n        $(this).removeClass(\"active-default\");\n      });\n    });\n  });\n});\n\n//# sourceURL=webpack:///./src/js/advanced-tabs.js?");

/***/ })

/******/ });