<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

class Form extends Generic
{
    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            array(
                'data' => array(
                    'id' => 'edit_form',
                    'action'  => $this->getUrl('*/*/save'),
                    'method'  => 'post',
                    'enctype' => 'multipart/form-data',
                ),
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
