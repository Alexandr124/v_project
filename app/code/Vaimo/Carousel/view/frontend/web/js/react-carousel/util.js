"use strict";

define([], function () {
  "use strict";

  var exports = {};
  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var getHorizontalClass = function getHorizontalClass(position) {
    var contentPositionClass = '';

    switch (+position) {
      case 1:
        contentPositionClass = 'left';
        break;

      case 2:
        contentPositionClass = 'center';
        break;

      case 3:
        contentPositionClass = 'right';
        break;

      case 4:
        contentPositionClass = 'full-width';
        break;

      default:
        contentPositionClass = 'center';
    }

    return contentPositionClass;
  };

  var getVerticalClass = function getVerticalClass(position) {
    var contentHorizontalClass = '';

    switch (+position) {
      case 1:
        contentHorizontalClass = 'top';
        break;

      case 2:
        contentHorizontalClass = 'middle';
        break;

      case 3:
        contentHorizontalClass = 'bottom';
        break;

      default:
        contentHorizontalClass = 'middle';
    }

    return contentHorizontalClass;
  };

  var getFontSizeTitle = function getFontSizeTitle(fontSize) {
    var fontSizeTitle = '';

    switch (+fontSize) {
      case 1:
        fontSizeTitle = 'font-size-x-small';
        break;

      case 2:
        fontSizeTitle = 'font-size-small';
        break;

      case 3:
        fontSizeTitle = 'font-size-base';
        break;

      case 4:
        fontSizeTitle = 'font-size-large';
        break;

      default:
        fontSizeTitle = 'font-size-x-large';
    }

    return fontSizeTitle;
  };

  var getThemeClass = function getThemeClass(theme) {
    var themeClass = ' theme-';

    switch (+theme) {
      case 0:
        themeClass += 'light';
        break;

      case 1:
        themeClass += 'medium';
        break;

      default:
        themeClass += 'dark';
    }

    return themeClass;
  };

  exports["default"] = {
    getHorizontalClass: getHorizontalClass,
    getVerticalClass: getVerticalClass,
    getFontSizeTitle: getFontSizeTitle,
    getThemeClass: getThemeClass
  };
  return exports.default;
});
