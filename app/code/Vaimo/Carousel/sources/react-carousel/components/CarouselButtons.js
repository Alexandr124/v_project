/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

import React from 'react';
import PropTypes from 'prop-types';

const CarouselButtons = props => {
    const { buttonFirstUrl, buttonFirstLabel, buttonSecondUrl, buttonSecondLabel } = props;

    return (
        <div className="carousel__buttons">
            {buttonFirstUrl && buttonFirstLabel && (
                <div className="carousel__button carousel__button--first">
                    <a href={buttonFirstUrl} className="action button tertiary">
                        <span>{buttonFirstLabel}</span>
                    </a>
                </div>
            )}

            {buttonSecondUrl && buttonSecondLabel && (
                <div className="carousel__button carousel__button--second">
                    <a href={buttonSecondUrl} className="action button tertiary">
                        <span>{buttonSecondLabel}</span>
                    </a>
                </div>
            )}
        </div>
    );
};

CarouselButtons.propTypes = {
    buttonFirstUrl: PropTypes.string,
    buttonFirstLabel: PropTypes.string,
    buttonSecondUrl: PropTypes.string,
    buttonSecondLabel: PropTypes.string
};

export default CarouselButtons;
