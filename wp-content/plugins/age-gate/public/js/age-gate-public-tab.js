!function(t){function e(r){if(n[r])return n[r].exports;var u=n[r]={i:r,l:!1,exports:{}};return t[r].call(u.exports,u,u.exports,e),u.l=!0,u.exports}var n={};e.m=t,e.c=n,e.d=function(t,n,r){e.o(t,n)||Object.defineProperty(t,n,{configurable:!1,enumerable:!0,get:r})},e.n=function(t){var n=t&&t.__esModule?function(){return t.default}:function(){return t};return e.d(n,"a",n),n},e.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},e.p="/",e(e.s=12)}({12:function(t,e,n){"use strict";!function(t){function e(){t(".age-gate-form-elements input").keyup(function(){this.value.length==this.maxLength&&t(this).closest("li").next("li").find("input").focus()})}age_gate_params.ajaxurl?jQuery(document).on("agegateshown",function(t){e()}):e()}(jQuery)}});