<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Value extends AbstractDb
{
    /**
     * Initialize Value
     */
    protected function _construct()
    {
        $this->_init('vaimo_carousel_value', 'value_id');
    }
}
