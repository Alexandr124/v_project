"use strict";

define(["react", "react-id-swiper", "CarouselImage", "CarouselContent", "CarouselUtil", "prop-types"], function (_react, _reactIdSwiper, _CarouselImage, _CarouselContent, _CarouselUtil, _propTypes) {
  "use strict";

  var exports = {};
  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var _react2 = _interopRequireDefault(_react);

  var _reactIdSwiper2 = _interopRequireDefault(_reactIdSwiper);

  var _CarouselImage2 = _interopRequireDefault(_CarouselImage);

  var _CarouselContent2 = _interopRequireDefault(_CarouselContent);

  var _propTypes2 = _interopRequireDefault(_propTypes);

  function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
      default: obj
    };
  }

  function _extends() {
    _extends = Object.assign || function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i];

        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }

      return target;
    };

    return _extends.apply(this, arguments);
  }

  function ownKeys(object, enumerableOnly) {
    var keys = Object.keys(object);

    if (Object.getOwnPropertySymbols) {
      var symbols = Object.getOwnPropertySymbols(object);
      if (enumerableOnly) symbols = symbols.filter(function (sym) {
        return Object.getOwnPropertyDescriptor(object, sym).enumerable;
      });
      keys.push.apply(keys, symbols);
    }

    return keys;
  }

  function _objectSpread(target) {
    for (var i = 1; i < arguments.length; i++) {
      var source = arguments[i] != null ? arguments[i] : {};

      if (i % 2) {
        ownKeys(source, true).forEach(function (key) {
          _defineProperty(target, key, source[key]);
        });
      } else if (Object.getOwnPropertyDescriptors) {
        Object.defineProperties(target, Object.getOwnPropertyDescriptors(source));
      } else {
        ownKeys(source).forEach(function (key) {
          Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key));
        });
      }
    }

    return target;
  }

  function _defineProperty(obj, key, value) {
    if (key in obj) {
      Object.defineProperty(obj, key, {
        value: value,
        enumerable: true,
        configurable: true,
        writable: true
      });
    } else {
      obj[key] = value;
    }

    return obj;
  }

  var VaimoCarousel = function VaimoCarousel(props) {
    var params = {};
    var items = props.items;
    var numberOfItems = items.length;
    var carouselExtraClassName = numberOfItems === 1 ? 'single' : 'multiple';
    var autoplayTimeOut = props.autoplay_timeout;
    var navigation = {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev'
    };
    var pagination = {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    };
    var autoplay = {
      delay: autoplayTimeOut,
      disableOnInteraction: false
    };
    params = props.arrow_enable ? _objectSpread({}, params, {
      navigation: navigation
    }) : params;
    params = props.dots_enable ? _objectSpread({}, params, {
      pagination: pagination
    }) : params;
    params = props.autoplay_enable ? _objectSpread({}, params, {
      autoplay: autoplay
    }) : params;
    return _react2["default"].createElement("div", {
      className: 'carousel widget'
    }, _react2["default"].createElement(_reactIdSwiper2["default"], _extends({
      className: "carousel__items carousel__items--".concat(carouselExtraClassName)
    }, params), items.map(function (item, index) {
      return _react2["default"].createElement("div", {
        className: "carousel_item theme-".concat((0, _CarouselUtil.getThemeClass)(item.theme)),
        key: index
      }, _react2["default"].createElement(_CarouselImage2["default"], {
        itemUrl: item.item_url,
        imageUrl: item.image,
        imageMediumUrl: item.image_medium,
        imageSmallUrl: item.image_small,
        altText: item.alt_text
      }), _react2["default"].createElement(_CarouselContent2["default"], item));
    })));
  };

  VaimoCarousel.propTypes = {
    arrow_enable: _propTypes2["default"].bool,
    autoplay_enable: _propTypes2["default"].bool,
    autoplay_hover_pause: _propTypes2["default"].bool,
    autoplay_timeout: _propTypes2["default"].number,
    baseUrl: _propTypes2["default"].string,
    create: _propTypes2["default"].string,
    disabled: _propTypes2["default"].bool,
    dots_enable: _propTypes2["default"].bool,
    enable: _propTypes2["default"].number,
    title: _propTypes2["default"].string,
    visible_items: _propTypes2["default"].number,
    items: _propTypes2["default"].arrayOf(_propTypes2["default"].shape({
      alt_text: _propTypes2["default"].string,
      box_title: _propTypes2["default"].string,
      button_first_color: _propTypes2["default"].string,
      button_first_label: _propTypes2["default"].string,
      button_first_url: _propTypes2["default"].string,
      button_second_color: _propTypes2["default"].string,
      button_second_label: _propTypes2["default"].string,
      button_second_url: _propTypes2["default"].string,
      carousel_id: _propTypes2["default"].string,
      content_position: _propTypes2["default"].string,
      content_position_vertical: _propTypes2["default"].string,
      content_width: _propTypes2["default"].string,
      created_at: _propTypes2["default"].string,
      custom: _propTypes2["default"].string,
      font_size_title: _propTypes2["default"].string,
      id: _propTypes2["default"].string,
      image: _propTypes2["default"].string,
      image_medium: _propTypes2["default"].string,
      image_small: _propTypes2["default"].string,
      item_type: _propTypes2["default"].string,
      item_url: _propTypes2["default"].string,
      sort_order: _propTypes2["default"].string,
      status: _propTypes2["default"].string,
      text: _propTypes2["default"].string,
      text_background_color: _propTypes2["default"].string,
      theme: _propTypes2["default"].string,
      title: _propTypes2["default"].string,
      updated_at: _propTypes2["default"].string,
      video: _propTypes2["default"].string
    }))
  };
  exports["default"] = VaimoCarousel;
  return exports.default;
});
