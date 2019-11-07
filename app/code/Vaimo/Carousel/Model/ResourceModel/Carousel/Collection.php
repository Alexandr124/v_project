<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model\ResourceModel\Carousel;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize Carousel Collection
     */
    protected function _construct()
    {
        $this->_init('Vaimo\Carousel\Model\Carousel', 'Vaimo\Carousel\Model\ResourceModel\Carousel');
    }
}
