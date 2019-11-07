/*
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

var config = {
    map: {
        '*': {
            react: 'https://unpkg.com/react@16/umd/react.development.js',
            'react-dom': 'https://unpkg.com/react-dom@16/umd/react-dom.development.js',
            'react-router-dom':
                'https://cdnjs.cloudflare.com/ajax/libs/react-router-dom/5.0.1/react-router-dom.js',
            'prop-types': 'Vaimo_Carousel/js/lib/prop-types/prop-types',
            'react-id-swiper': 'js/lib/react-id-swiper/react-id-swiper.min',
            vaimoCarouselOwlCarousel: 'Vaimo_Carousel/js/lib/owl.carousel',
            vaimoCarousel: 'Vaimo_Carousel/js/carousel',
            Swiper: 'Vaimo_Carousel/js/lib/swiper/swiper.min',
            vaimoReactCarousel: 'Vaimo_Carousel/js/react-carousel/carousel-index',
            CarouselUtil: 'Vaimo_Carousel/js/react-carousel/util',
            VaimoCarousel: 'Vaimo_Carousel/js/react-carousel/components/VaimoCarousel',
            CarouselContent: 'Vaimo_Carousel/js/react-carousel/components/CarouselContent',
            CarouselButtons: 'Vaimo_Carousel/js/react-carousel/components/CarouselButtons',
            CarouselImage: 'Vaimo_Carousel/js/react-carousel/components/CarouselImage'
        }
    },
    shim: {
        vaimoCarouselOwlCarousel: {
            deps: ['jquery']
        }
    }
};
