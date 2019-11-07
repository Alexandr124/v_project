/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

import React from 'react';
import Swiper from 'react-id-swiper';
import CarouselImage from 'CarouselImage';
import CarouselContent from 'CarouselContent';
import { getThemeClass } from 'CarouselUtil';
import PropTypes from 'prop-types';

const VaimoCarousel = props => {
    let params = {};
    const { items } = props;
    const numberOfItems = items.length;
    const carouselExtraClassName = numberOfItems === 1 ? 'single' : 'multiple';
    const autoplayTimeOut = props.autoplay_timeout;
    const navigation = {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
    };

    const pagination = {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true
    };

    const autoplay = {
        delay: autoplayTimeOut,
        disableOnInteraction: false
    };

    params = props.arrow_enable ? { ...params, navigation } : params;
    params = props.dots_enable ? { ...params, pagination } : params;
    params = props.autoplay_enable ? { ...params, autoplay } : params;

    return (
        <div className={'carousel widget'}>
            <Swiper
                className={`carousel__items carousel__items--${carouselExtraClassName}`}
                {...params}
            >
                {items.map((item, index) => {
                    return (
                        <div
                            className={`carousel_item theme-${getThemeClass(item.theme)}`}
                            key={index}
                        >
                            <CarouselImage
                                itemUrl={item.item_url}
                                imageUrl={item.image}
                                imageMediumUrl={item.image_medium}
                                imageSmallUrl={item.image_small}
                                altText={item.alt_text}
                            />
                            <CarouselContent {...item} />
                        </div>
                    );
                })}
            </Swiper>
        </div>
    );
};

VaimoCarousel.propTypes = {
    arrow_enable: PropTypes.bool,
    autoplay_enable: PropTypes.bool,
    autoplay_hover_pause: PropTypes.bool,
    autoplay_timeout: PropTypes.number,
    baseUrl: PropTypes.string,
    create: PropTypes.string,
    disabled: PropTypes.bool,
    dots_enable: PropTypes.bool,
    enable: PropTypes.number,
    title: PropTypes.string,
    visible_items: PropTypes.number,
    items: PropTypes.arrayOf(
        PropTypes.shape({
            alt_text: PropTypes.string,
            box_title: PropTypes.string,
            button_first_color: PropTypes.string,
            button_first_label: PropTypes.string,
            button_first_url: PropTypes.string,
            button_second_color: PropTypes.string,
            button_second_label: PropTypes.string,
            button_second_url: PropTypes.string,
            carousel_id: PropTypes.string,
            content_position: PropTypes.string,
            content_position_vertical: PropTypes.string,
            content_width: PropTypes.string,
            created_at: PropTypes.string,
            custom: PropTypes.string,
            font_size_title: PropTypes.string,
            id: PropTypes.string,
            image: PropTypes.string,
            image_medium: PropTypes.string,
            image_small: PropTypes.string,
            item_type: PropTypes.string,
            item_url: PropTypes.string,
            sort_order: PropTypes.string,
            status: PropTypes.string,
            text: PropTypes.string,
            text_background_color: PropTypes.string,
            theme: PropTypes.string,
            title: PropTypes.string,
            updated_at: PropTypes.string,
            video: PropTypes.string
        })
    )
};

export default VaimoCarousel;
