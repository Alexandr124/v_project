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

  var CarouselImage = function CarouselImage(props) {
    var itemUrl = props.itemUrl,
        imageUrl = props.imageUrl,
        imageMediumUrl = props.imageMediumUrl,
        imageSmallUrl = props.imageSmallUrl,
        altText = props.altText;
    return _react2["default"].createElement("a", {
      href: itemUrl ? itemUrl : '#',
      target: "_blank",
      className: "carousel__image__wrapper"
    }, _react2["default"].createElement("div", {
      className: "carousel__image"
    }, _react2["default"].createElement("picture", null, _react2["default"].createElement("source", {
      srcSet: 'media/' + imageUrl,
      media: "(min-width: 992px)"
    }), imageMediumUrl && _react2["default"].createElement("source", {
      srcSet: 'media/' + imageMediumUrl,
      media: "(min-width: 768px)"
    }), imageSmallUrl && _react2["default"].createElement("source", {
      srcSet: 'media/' + imageSmallUrl,
      media: "(min-width: 320px)"
    }), _react2["default"].createElement("img", {
      src: 'media/' + imageUrl,
      alt: altText
    }))));
  };

  CarouselImage.propTypes = {
    itemUrl: _propTypes2["default"].string,
    imageUrl: _propTypes2["default"].string,
    imageMediumUrl: _propTypes2["default"].string,
    imageSmallUrl: _propTypes2["default"].string,
    altText: _propTypes2["default"].string
  };
  exports["default"] = CarouselImage;
  return exports.default;
});
//# sourceMappingURL=app/design/frontend/Vaimo/veke/web/js/compiled/carousel-index.js.map
