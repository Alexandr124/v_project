<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Vaimo\Carousel\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class FontSize extends AbstractHelper
{
    const X_SMALL_KEY = 1;
    const SMALL_KEY = 2;
    const BASE_KEY = 3;
    const LARGE_KEY = 4;
    const X_LARGE_KEY = 5;

    protected $arrayOptionClass = [
        self::X_SMALL_KEY => 'font-size-x-small',
        self::SMALL_KEY => 'font-size-small',
        self::BASE_KEY => 'font-size-base',
        self::LARGE_KEY => 'font-size-large',
        self::X_LARGE_KEY => 'font-size-x-large',
    ];

    /**
     * @param $optionKey
     * @return string
     */
    public function getClass($optionKey)
    {
        return $this->arrayOptionClass[$optionKey] ?? '';
    }

    /**
     * @return array
     */
    public static function getOptionLabel()
    {
        return [
            self::X_SMALL_KEY => __('x-small'),
            self::SMALL_KEY => __('small'),
            self::BASE_KEY => __('base'),
            self::LARGE_KEY => __('large'),
            self::X_LARGE_KEY => __('x-large'),
        ];
    }
}
