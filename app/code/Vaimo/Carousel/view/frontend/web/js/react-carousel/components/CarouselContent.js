"use strict";

define(["react", "CarouselButtons", "prop-types", "CarouselUtil"], function (_react, _CarouselButtons, _propTypes, _CarouselUtil) {
  "use strict";

  var exports = {};
  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var _react2 = _interopRequireDefault(_react);

  var _CarouselButtons2 = _interopRequireDefault(_CarouselButtons);

  var _propTypes2 = _interopRequireDefault(_propTypes);

  function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
      default: obj
    };
  }

  var CarouselContent = function CarouselContent(props) {
    var item_url = props.item_url,
        title = props.title,
        text = props.text;
    return _react2["default"].createElement("div", {
      className: "carousel__content carousel__content--".concat((0, _CarouselUtil.getHorizontalClass)(props.content_position), " carousel__content--").concat((0, _CarouselUtil.getVerticalClass)(props.content_position_vertical))
    }, title && _react2["default"].createElement("a", {
      href: item_url ? item_url : '#',
      target: "_blank"
    }, _react2["default"].createElement("div", {
      className: "carousel__title"
    }, _react2["default"].createElement("h2", {
      className: (0, _CarouselUtil.getFontSizeTitle)(props.font_size_title)
    }, title))), text.length > 0 && _react2["default"].createElement("div", {
      className: "carousel__text",
      dangerouslySetInnerHTML: {
        __html: text
      }
    }), _react2["default"].createElement(_CarouselButtons2["default"], {
      buttonFirstUrl: props.button_first_url,
      buttonFirstLabel: props.button_first_label,
      buttonSecondUrl: props.button_second_url,
      buttonSecondLabel: props.button_second_label
    }));
  };

  CarouselContent.propTypes = {
    item_url: _propTypes2["default"].string,
    title: _propTypes2["default"].string,
    text: _propTypes2["default"].string,
    content_position: _propTypes2["default"].string,
    content_position_vertical: _propTypes2["default"].string,
    font_size_title: _propTypes2["default"].string,
    button_first_url: _propTypes2["default"].string,
    button_first_label: _propTypes2["default"].string,
    button_second_url: _propTypes2["default"].string,
    button_second_label: _propTypes2["default"].string
  };
  exports["default"] = CarouselContent;
  return exports.default;
});
