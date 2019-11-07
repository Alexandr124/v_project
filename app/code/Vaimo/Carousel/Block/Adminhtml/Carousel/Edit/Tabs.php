<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('carousel_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Carousel Information'));
    }
}
