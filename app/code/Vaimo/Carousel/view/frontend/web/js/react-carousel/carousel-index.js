"use strict";

define(["jquery", "react", "react-dom", "VaimoCarousel"], function (_jquery, _react, _reactDom, _VaimoCarousel) {
  "use strict";

  var exports = {};
  Object.defineProperty(exports, "__esModule", {
    value: true
  });

  var _jquery2 = _interopRequireDefault(_jquery);

  var _react2 = _interopRequireDefault(_react);

  var _reactDom2 = _interopRequireDefault(_reactDom);

  var _VaimoCarousel2 = _interopRequireDefault(_VaimoCarousel);

  function _interopRequireDefault(obj) {
    return obj && obj.__esModule ? obj : {
      default: obj
    };
  }

  _jquery2["default"].widget('vaimo.vaimoReactCarousel', {
    options: {
      baseUrl: null,
      title: null,
      enable: null,
      arrow_enable: null,
      dots_enable: null,
      autoplay_enable: null,
      autoplay_timeout: null,
      autoplay_hover_pause: null,
      visible_items: null,
      items: null
    },
    _create: function _create() {
      (0, _jquery2["default"])('.carousel__placeholder').hide();
      return _reactDom2["default"].render(_react2["default"].createElement(_VaimoCarousel2["default"], this.options), (0, _jquery2["default"])(this.element)[0]);
    }
  });

  exports["default"] = _jquery2["default"].vaimo.vaimoReactCarousel;
  return exports.default;
});
//# sourceMappingURL=app/design/frontend/Vaimo/veke/web/js/compiled/carousel-index.js.map
