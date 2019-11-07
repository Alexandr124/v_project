/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */

// Libraries import
import $ from 'jquery';
import React from 'react';
import ReactDOM from 'react-dom';

// Components import
import VaimoCarousel from 'VaimoCarousel';

$.widget('vaimo.vaimoReactCarousel', {
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
    _create: function() {
        // Hide placeholder carousel when main carousel loads in.
        $('.carousel__placeholder').hide();
        return ReactDOM.render(
            React.createElement(VaimoCarousel, this.options),
            $(this.element)[0]
        );
    }
});

export default $.vaimo.vaimoReactCarousel;
