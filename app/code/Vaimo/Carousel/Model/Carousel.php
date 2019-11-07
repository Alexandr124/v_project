<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Registry;
use Vaimo\Carousel\Model\ResourceModel\Carousel\Collection;
use Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory;

class Carousel extends AbstractModel
{
    /**
     * Item collection factory.
     *
     * @var CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param Registry $registry
     * @param CollectionFactory $itemCollectionFactory
     * @param \Vaimo\Carousel\Model\ResourceModel\Carousel $resource
     * @param Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        Registry $registry,
        CollectionFactory $itemCollectionFactory,
        \Vaimo\Carousel\Model\ResourceModel\Carousel $resource,
        Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );

        $this->itemCollectionFactory = $itemCollectionFactory;
    }

    /**
     * Get carousel item collection.
     *
     * @return \Vaimo\Carousel\Model\ResourceModel\Item\Collection
     */
    public function getCarouselItemCollection()
    {
        return $this->itemCollectionFactory->create()->addFieldToFilter('carousel_id', $this->getId());
    }
}
