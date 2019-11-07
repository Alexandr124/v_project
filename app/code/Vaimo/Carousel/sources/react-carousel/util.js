/**
 * Copyright © Vaimo Group. All rights reserved.
 * See LICENSE_VAIMO.txt for license details.
 */

/**
 * Return horizontal class based on position from admin
 * @param position
 * @returns {string}
 */
const getHorizontalClass = position => {
    let contentPositionClass = '';

    switch (+position) {
        case 1:
            contentPositionClass = 'left';
            break;
        case 2:
            contentPositionClass = 'center';
            break;
        case 3:
            contentPositionClass = 'right';
            break;
        case 4:
            contentPositionClass = 'full-width';
            break;
        default:
            contentPositionClass = 'center';
    }

    return contentPositionClass;
};

/**
 * Return vertical class based on position from admin
 * @param position
 * @returns {string}
 */
const getVerticalClass = position => {
    let contentHorizontalClass = '';

    switch (+position) {
        case 1:
            contentHorizontalClass = 'top';
            break;
        case 2:
            contentHorizontalClass = 'middle';
            break;
        case 3:
            contentHorizontalClass = 'bottom';
            break;
        default:
            contentHorizontalClass = 'middle';
    }

    return contentHorizontalClass;
};

/**
 * Return font-size class based on font-size value from admin
 * @param fontSize
 * @returns {string}
 */
const getFontSizeTitle = fontSize => {
    let fontSizeTitle = '';

    switch (+fontSize) {
        case 1:
            fontSizeTitle = 'font-size-x-small';
            break;
        case 2:
            fontSizeTitle = 'font-size-small';
            break;
        case 3:
            fontSizeTitle = 'font-size-base';
            break;
        case 4:
            fontSizeTitle = 'font-size-large';
            break;
        default:
            fontSizeTitle = 'font-size-x-large';
    }

    return fontSizeTitle;
};

/**
 * Return theme class based on theme value from admin
 * @param theme
 * @returns {string}
 */
const getThemeClass = theme => {
    let themeClass = ' theme-';

    switch (+theme) {
        case 0:
            themeClass += 'light';
            break;
        case 1:
            themeClass += 'medium';
            break;
        default:
            themeClass += 'dark';
    }

    return themeClass;
};

export default { getHorizontalClass, getVerticalClass, getFontSizeTitle, getThemeClass };
