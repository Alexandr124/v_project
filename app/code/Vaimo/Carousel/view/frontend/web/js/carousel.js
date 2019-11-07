/**
 * Copyright © 2009-2016 Vaimo AB. All rights reserved.
 * See LICENSE.txt for license details.
 */
;define([
    'jquery',
    'vaimoCarouselOwlCarousel'
], function($) {
    'use strict';

    $.widget('vaimo.carousel', {
        options: {
            container: '.js-carousel', // overridden by template
            numberOfItems: 1, // overridden by template
            items: 1, // overridden by template
            loop: true,
            mouseDrag: true,
            touchDrag: true,
            pullDrag: true,
            nav: false,
            navRewind: true,
            dots: true,
            lazyLoad: false,
            autoplay: false,
            autoplayHoverPause: false,
            autoplayTimeout: 5000,
            video: false,
            videoHeight: false,
            videoWidth: false,
            animateOut: 'fadeOut'
        },
        _create: function() {
            this._initiateLibrary();
        },
        _initiateLibrary: function() {
            var isMoreThanOneItem = this.options.numberOfItems > 1;

            $(this.options.container).owlCarousel({
                items: isMoreThanOneItem ? this.options.items : 1,
                loop: isMoreThanOneItem ? this.options.loop : false,
                mouseDrag: isMoreThanOneItem ? this.options.mouseDrag : false,
                touchDrag: isMoreThanOneItem ? this.options.touchDrag : false,
                pullDrag: isMoreThanOneItem ? this.options.pullDrag : false,
                nav: isMoreThanOneItem ? this.options.nav : false,
                dots: isMoreThanOneItem ? this.options.dots : false,
                autoplay: isMoreThanOneItem ? this.options.autoplay : false,
                autoplayHoverPause: isMoreThanOneItem ? this.options.autoplayHoverPause : false,
                autoplayTimeout: isMoreThanOneItem ? this.options.autoplayTimeout : 5000,
                animateOut: isMoreThanOneItem ? this.options.animateOut : false
            });
        }
    });

    return $.vaimo.carousel;
});