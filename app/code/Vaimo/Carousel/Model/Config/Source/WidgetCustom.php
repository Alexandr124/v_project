<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model\Config\Source;

class WidgetCustom extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * Carousel collection factory.
     *
     * @var \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory
     */
    protected $carouselCollectionFactory;

    /**
     * @param \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory
     */
    public function __construct(
        \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory

    ) {
        $this->carouselCollectionFactory = $carouselCollectionFactory;
    }

    /**
     * @return mixed
     */
    public function getCarouselCollection()
    {
        $collection = $this->carouselCollectionFactory->create();

        return $collection;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $carouselCollection = $this->getCarouselCollection();

        $values = [];

        $values[] = [
            'value' => 0,
            'label' => __('Select Carousel')
        ];
        
        foreach ($carouselCollection as $carousel) {
            $values[] = [
                'value' => $carousel->getId(), 'label' => $carousel->getTitle()
            ];
        }

        return $values;
    }
}
