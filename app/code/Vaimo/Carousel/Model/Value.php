<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model;

use \Magento\Framework\Model\AbstractModel;

class Value extends AbstractModel
{
    /**
     * constructor.
     *
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Vaimo\Carousel\Model\ResourceModel\Value $resource
     * @param \Vaimo\Carousel\Model\ResourceModel\Value\Collection $resourceCollection
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Vaimo\Carousel\Model\ResourceModel\Value $resource,
        \Vaimo\Carousel\Model\ResourceModel\Value\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

    /**
     * Load attribute value.
     *
     * @param int $itemId
     * @param int $storeViewId
     * @param string $attributeCode
     *
     * @return $this
     */
    public function loadAttributeValue($itemId, $storeViewId, $attributeCode)
    {
        $attributeValue = $this->getResourceCollection()
            ->addFieldToFilter('item_id', $itemId)
            ->addFieldToFilter('store_id', $storeViewId)
            ->addFieldToFilter('attribute_code', $attributeCode)
            ->setPageSize(1)->setCurPage(1)
            ->getFirstItem();

        $this->setData('item_id', $itemId)
            ->setData('store_id', $storeViewId)
            ->setData('attribute_code', $attributeCode);
        if ($attributeValue->getId()) {
            $this->addData($attributeValue->getData())
                ->setId($attributeValue->getId());
        }

        return $this;
    }
}
