"use strict";

define(["react", "prop-types"], function (_react, _propTypes) {
  "use strict";

  var exports = {};
  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var _react2 = _interopRequireDefault(_react);

  var _propTypes2 = _interopRequireDefault(_propTypes);

  function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
      default: obj
    };
  }

  var CarouselButtons = function CarouselButtons(props) {
    var buttonFirstUrl = props.buttonFirstUrl,
        buttonFirstLabel = props.buttonFirstLabel,
        buttonSecondUrl = props.buttonSecondUrl,
        buttonSecondLabel = props.buttonSecondLabel;
    return _react2["default"].createElement("div", {
      className: "carousel__buttons"
    }, buttonFirstUrl && buttonFirstLabel && _react2["default"].createElement("div", {
      className: "carousel__button carousel__button--first"
    }, _react2["default"].createElement("a", {
      href: buttonFirstUrl,
      className: "action button tertiary"
    }, _react2["default"].createElement("span", null, buttonFirstLabel))), buttonSecondUrl && buttonSecondLabel && _react2["default"].createElement("div", {
      className: "carousel__button carousel__button--second"
    }, _react2["default"].createElement("a", {
      href: buttonSecondUrl,
      className: "action button tertiary"
    }, _react2["default"].createElement("span", null, buttonSecondLabel))));
  };

  CarouselButtons.propTypes = {
    buttonFirstUrl: _propTypes2["default"].string,
    buttonFirstLabel: _propTypes2["default"].string,
    buttonSecondUrl: _propTypes2["default"].string,
    buttonSecondLabel: _propTypes2["default"].string
  };
  exports["default"] = CarouselButtons;
  return exports.default;
});