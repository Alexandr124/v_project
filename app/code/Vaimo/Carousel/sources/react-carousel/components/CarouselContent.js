/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

import React from 'react';
import CarouselButtons from 'CarouselButtons';
import PropTypes from 'prop-types';
import { getHorizontalClass, getVerticalClass, getFontSizeTitle } from 'CarouselUtil';

const CarouselContent = props => {
  const { item_url, title, text } = props;

  return (
      <div
          className={`carousel__content carousel__content--${getHorizontalClass(
              props.content_position
          )} carousel__content--${getVerticalClass(props.content_position_vertical)}`}
      >
        {title && (
            <a href={item_url ? item_url : '#'} target="_blank">
              <div className="carousel__title">
                <h2 className={getFontSizeTitle(props.font_size_title)}>{title}</h2>
              </div>
            </a>
        )}
        {text.length > 0 && (
            <div className="carousel__text" dangerouslySetInnerHTML={{ __html: text }} />
        )}
        <CarouselButtons
            buttonFirstUrl={props.button_first_url}
            buttonFirstLabel={props.button_first_label}
            buttonSecondUrl={props.button_second_url}
            buttonSecondLabel={props.button_second_label}
        />
      </div>
  );
};

CarouselContent.propTypes = {
  item_url: PropTypes.string,
  title: PropTypes.string,
  text: PropTypes.string,
  content_position: PropTypes.string,
  content_position_vertical: PropTypes.string,
  font_size_title: PropTypes.string,
  button_first_url: PropTypes.string,
  button_first_label: PropTypes.string,
  button_second_url: PropTypes.string,
  button_second_label: PropTypes.string
};

export default CarouselContent;
