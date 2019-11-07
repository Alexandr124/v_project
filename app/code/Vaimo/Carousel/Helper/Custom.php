<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Stdlib\DateTime\DateTime;
use Vaimo\Carousel\Model\Carousel;
use Vaimo\Carousel\Model\Item;

/**
 * Class Custom
 * @package Vaimo\Carousel\Helper
 */
class Custom extends AbstractHelper
{
    /**
     * @var Carousel
     */
    protected $carouselModel;

    /**
     * @var array
     */
    protected $configFieldsCarousel;

    /**
     * @var array
     */
    protected $configFieldsItem;

    /**
     * @var int
     */
    protected $carouselId;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Vaimo\Carousel\Model\Item
     */
    protected $item;

    /**
     * @param Context $context
     * @param Carousel $carouselModel
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     * @param \Vaimo\Carousel\Model\Item $item
     */
    public function __construct(
        Context $context,
        Carousel $carouselModel,
        DateTime $date,
        Item $item
    ) {
        parent::__construct($context);

        $this->carouselModel = $carouselModel;
        $this->date = $date;
        $this->scopeConfig = $context->getScopeConfig();
        $this->item = $item;
    }

    /**
     * @param $carouselId
     * @return \Magento\Framework\DataObject
     */
    public function getCarouselConfigOptions($carouselId)
    {
        if ($this->carouselId != $carouselId && is_null($this->configFieldsCarousel)) {

            $this->carouselId = $carouselId;

            $this->configFieldsCarousel = [
                'title',
                'status',
                'nav',
                'dots',
                'items',
                'merge',
            ];
        }
        if (is_null($this->configFieldsItem)) {
            $this->configFieldsItem = [
                'title',
                'text',
                'status',
                'item_url',
                'item_type',
                'image',
                'image_medium',
                'image_small',
                'alt_text',
                'button_first_label',
                'button_first_url',
                'button_second_label',
                'button_second_url',
                'custom',
            ];
        }

        /* @var Carousel $carousel */
        $carousel = $this->carouselModel->load($carouselId);

        if (!count($this->configFieldsCarousel)) {
            return new \Magento\Framework\DataObject();
        }

        $carouselConfig = [];
        foreach ($this->configFieldsCarousel as $field) {
            $carouselConfig[$field] = $carousel->getData($field);
        }

        $carouselItemsCollection = $carousel->getCarouselItemCollection();
        $carouselItemsCollection->setOrder('sort_order', 'ASC');

        $itemConfig = [];
        foreach ($carouselItemsCollection as $item) {

            if (!$item->getStatus()) {
                continue;
            }

            $itemDetails = [];
            foreach ($this->configFieldsItem as $field) {
                $itemDetails[$field] = $item->getData($field);
            }
            $itemConfig[$item->getId()] = $itemDetails;
        }

        $configData = new \Magento\Framework\DataObject();

        $configData->setCarouselConfig($carouselConfig);
        $configData->setItemConfig($itemConfig);

        return $configData;
    }
}
