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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

var app = angular.module('authyDemo', []);
app.controller('LoginController', function ($scope, $http, $window) {
  $scope.setup = {};

  $scope.login = function () {
    $http.post('/api/login', $scope.setup).success(function (data, status, headers, config) {
      console.log("Login success: ", data);
      $window.location.href = $window.location.origin + "/2fa";
    }).error(function (data, status, headers, config) {
      console.error("Login error: ", data);
      alert("Error logging in.  Check console");
    });
  };
});
app.controller('RegistrationController', function ($scope, $http, $window) {
  $scope.setup = {};
  $scope.info = false;
  $scope.disabledRegister = true;

  $scope.lookup = function () {
    $http.post('/api/lookup', $scope.setup).success(function (data, status, headers, config) {
      console.log("Success Lookup: ", data);
      $scope.info = data.info.carrier;

      if ($scope.info.type === "mobile") {
        $scope.disabledRegister = false;
        alert("Lookup has determined you are registering a mobile phone number.");
      } else {
        $scope.disabledRegister = true;
        alert("You must register with a mobile number only.");
      }
    }).error(function (data, status, headers, config) {
      console.error("Failure Lookup: ", data);
    });
  };

  $scope.register = function () {
    if ($scope.password1 === $scope.password2 && $scope.password1 !== "") {
      // making sure the passwords are the same and setting it on the
      // object we'll pass to the registration endpoint.
      $scope.setup.password = $scope.password1;
      $http.post('/api/user/register', $scope.setup).success(function (data, status, headers, config) {
        console.log("Success registering: ", data);
        $window.location.href = $window.location.origin + "/2fa";
      }).error(function (data, status, headers, config) {
        console.error("Registration error: ", data);
        alert("Error registering.  Check console");
      });
    } else {
      alert("Passwords do not match");
    }
  };
});
app.controller('AuthyController', function ($scope, $http, $window, $interval) {
  var pollingID;
  $scope.setup = {};

  $scope.logout = function () {
    $http.get('/api/logout').success(function (data, status, headers, config) {
      console.log("Logout Response: ", data);
      $window.location.href = $window.location.origin;
    }).error(function (data, status, headers, config) {
      console.error("Logout Error: ", data);
    });
  };
  /**
   * Request a token via SMS
   */


  $scope.sms = function () {
    $http.post('/api/authy/sms').success(function (data, status, headers, config) {
      console.log("SMS sent: ", data);
    }).error(function (data, status, headers, config) {
      console.error("SMS error: ", data);
      alert("Problem sending SMS");
    });
  };
  /**
   * Request a Voice delivered token
   */


  $scope.voice = function () {
    $http.post('/api/authy/voice').success(function (data, status, headers, config) {
      console.log("Phone call initialized: ", data);
    }).error(function (data, status, headers, config) {
      console.error("Voice call error: ", data);
      alert("Problem making Voice Call");
    });
  };
  /**
   * Verify a SMS, Voice or SoftToken
   */


  $scope.verify = function () {
    $http.post('/api/authy/verify', {
      token: $scope.setup.token
    }).success(function (data, status, headers, config) {
      console.log("2FA success ", data);
      $window.location.href = $window.location.origin + "/protected";
    }).error(function (data, status, headers, config) {
      console.error("Verify error: ", data);
      alert("Problem verifying token");
    });
  };
  /**
   * Request a OneTouch transaction
   */


  $scope.onetouch = function () {
    $http.post('/api/authy/onetouch').success(function (data, status, headers, config) {
      console.log("OneTouch success", data);
      /**
       * Poll for the status change.  Every 5 seconds for 12 times.  1 minute.
       */

      pollingID = $interval(oneTouchStatus, 5000, 12);
    }).error(function (data, status, headers, config) {
      console.error("Onetouch error: ", data);
      alert("Problem creating OneTouch request");
    });
  };
  /**
   * Request the OneTouch status.
   */


  function oneTouchStatus() {
    $http.post('/api/authy/onetouchstatus').success(function (data, status, headers, config) {
      console.log("OneTouch Status: ", data);

      if (data.approval_request.status === "approved") {
        $window.location.href = $window.location.origin + "/protected";
        $interval.cancel(pollingID);
      } else {
        console.log("One Touch Request not yet approved");
      }
    }).error(function (data, status, headers, config) {
      console.log("OneTouch Polling Status: ", data);
      alert("Something went wrong with the OneTouch polling");
      $interval.cancel(pollingID);
    });
  }
});
app.controller('PhoneVerificationController', function ($scope, $http, $window, $timeout) {
  $scope.setup = {
    via: "sms",
    locale: "en"
  };
  $scope.view = {
    start: true
  };
  $scope.info = false;
  $scope.disabled = true;

  $scope.lookup = function () {
    $scope.info = false;
    $http.post('/api/lookup', $scope.setup).success(function (data, status, headers, config) {
      console.log("Success Lookup: ", data);
      $scope.info = data.info.carrier;

      if ($scope.info.type === "mobile") {
        $scope.disabled = false;
        alert("Lookup has determined you are registering a mobile phone number.");
      } else if ($scope.info.type === "landline") {
        $scope.disabled = false;
        $scope.setup.via = "call";
        alert("Lookup has determined you are registering with a landline.");
      } else {
        $scope.disabled = true;
        alert("You must register with a mobile or landline number only.  No VOIP.");
      }
    }).error(function (data, status, headers, config) {
      console.error("Failure Lookup: ", data);
    });
  };
  /**
   * Initialize Phone Verification
   */


  $scope.startVerification = function () {
    $http.post('/api/verification/start', $scope.setup).success(function (data, status, headers, config) {
      $scope.view.start = false;
      console.log("Verification started: ", data);
    }).error(function (data, status, headers, config) {
      console.error("Phone verification error: ", data);
    });
  };
  /**
   * Verify phone token
   */


  $scope.verifyToken = function () {
    $http.post('/api/verification/verify', $scope.setup).success(function (data, status, headers, config) {
      console.log("Phone Verification Success success: ", data);
      $window.location.href = $window.location.origin + "/verified";
    }).error(function (data, status, headers, config) {
      console.error("Verification error: ", data);
      alert("Error verifying the token.  Check console for details.");
    });
  };

  $scope.logout = function () {
    $window.location.href = $window.location.origin;
  };
});

/***/ }),

/***/ "./resources/sass/app.scss":
/*!*********************************!*\
  !*** ./resources/sass/app.scss ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/app.scss ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/tneiderhiser/twilio/projects/signal-2019-verify-php/resources/js/app.js */"./resources/js/app.js");
module.exports = __webpack_require__(/*! /Users/tneiderhiser/twilio/projects/signal-2019-verify-php/resources/sass/app.scss */"./resources/sass/app.scss");


/***/ })

/******/ });