<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Item;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Vaimo_Carousel';
        $this->_controller = 'adminhtml_item';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Item'));
        $this->buttonList->update('delete', 'label', __('Delete Item'));

        if ($this->getRequest()->getParam('current_carousel_id')) {
            $this->buttonList->remove('save');
            $this->buttonList->remove('delete');
            $this->buttonList->remove('back');
            $this->buttonList->add(
                'close_window',
                [
                    'label' => __('Close Window'),
                    'onclick' => 'window.close();',
                ], 10
            );

            $this->buttonList->add(
                'save_and_continue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'onclick' => 'customsaveAndContinueEdit()',
                ], 10
            );

            $this->buttonList->add(
                'save_and_close',
                [
                    'label' => __('Save and Close Window'),
                    'class' => 'save_and_close',
                    'onclick' => 'saveAndCloseWindow()',
                ], 10
            );

            $this->_formScripts[] = "
                require(['jquery'], function($){
                    $(document).ready(function(){
                        var input = $('<input class=\"custom-button-submit\" type=\"submit\" hidden=\"true\" />');
                        $(edit_form).append(input);

                        window.customsaveAndContinueEdit = function (){
                            edit_form.action = '" . $this->getSaveAndContinueUrl() . "';
                            $('.custom-button-submit').trigger('click');

                        }

                        window.saveAndCloseWindow = function (){
                            edit_form.action = '" . $this->getSaveAndCloseWindowUrl() . "';
                            $('.custom-button-submit').trigger('click');
                        }
                        
                    });
                });

                function toggleEditor() {
                    if (tinyMCE.getInstanceById('page_text') == null) {
                        tinyMCE.execCommand('mceAddControl', false, 'page_text');
                    } else {
                        tinyMCE.execCommand('mceRemoveControl', false, 'page_text');
                    }
                };";

            if ($itemId = $this->getRequest()->getParam('id')) {
                $this->_formScripts[] = '
                    window.id = ' . $itemId . ';
                ';
            }
        } else {
            $this->buttonList->add(
                'save_and_continue',
                [
                    'label' => __('Save and Continue Edit'),
                    'class' => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ],
                ],
                10
            );
        }

        if ($this->getRequest()->getParam('saveandclose')) {
            $this->_formScripts[] = 'window.close();';
        }
    }

    /**
     * Get save and continue url.
     *
     * @return string
     */
    protected function getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'tab' => '{{tab_id}}',
                'store' => $this->getRequest()->getParam('store'),
                'id' => $this->getRequest()->getParam('id'),
                'current_carousel_id' => $this->getRequest()->getParam('current_carousel_id'),
            ]
        );
    }

    /**
     * Get save and close window url.
     *
     * @return string
     */
    protected function getSaveAndCloseWindowUrl()
    {
        return $this->getUrl(
            '*/*/save',
            [
                '_current' => true,
                'back' => 'edit',
                'tab' => '{{tab_id}}',
                'store' => $this->getRequest()->getParam('store'),
                'id' => $this->getRequest()->getParam('id'),
                'current_carousel_id' => $this->getRequest()->getParam('current_carousel_id'),
                'saveandclose' => 1,
            ]
        );
    }
}
