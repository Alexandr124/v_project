/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

import React from 'react';
import PropTypes from 'prop-types';

const CarouselImage = props => {
    const { itemUrl, imageUrl, imageMediumUrl, imageSmallUrl, altText } = props;
    return (
        <a href={itemUrl ? itemUrl : '#'} target="_blank" className={`carousel__image__wrapper`}>
            <div className="carousel__image">
                <picture>
                    <source srcSet={'media/' + imageUrl} media="(min-width: 992px)" />
                    {imageMediumUrl && (
                        <source srcSet={'media/' + imageMediumUrl} media="(min-width: 768px)" />
                    )}
                    {imageSmallUrl && (
                        <source srcSet={'media/' + imageSmallUrl} media="(min-width: 320px)" />
                    )}
                    <img src={'media/' + imageUrl} alt={altText} />
                </picture>
            </div>
        </a>
    );
};

CarouselImage.propTypes = {
    itemUrl: PropTypes.string,
    imageUrl: PropTypes.string,
    imageMediumUrl: PropTypes.string,
    imageSmallUrl: PropTypes.string,
    altText: PropTypes.string
};

export default CarouselImage;
