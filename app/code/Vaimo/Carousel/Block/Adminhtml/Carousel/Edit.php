<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

class Edit extends Container
{
    /**
     * Core registry.
     *
     * @var coreRegistry
     */
    protected $coreRegistry;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Vaimo_Carousel';
        $this->_controller = 'adminhtml_carousel';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Carousel'));
        $this->buttonList->update('delete', 'label', __('Delete Carousel'));

        if ($this->getCarousel()->getId()) {
            $this->buttonList->add(
                'create_item',
                [
                    'label' => __('Add Item'),
                    'class' => 'add',
                    'onclick' => 'openItemPopupWindow(\'' . $this->getCreateItemUrl() . '\')',
                ],
                1
            );
        }

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
            ], 10
        );

        /*
         * javascript variable
         * create_item_popupwindow : window popup
         * create_item_popupwindow.item_id : Id of item after creating in popup
         * itemGridJsObject : grid object
         * itemGridJsObject.reloadParams['item[]'] : An array contain Ids of items, ex. Array [ "2", "30", "31", "32", .. ]
         * edit_form: form
         * edit_form.carousel_item: input for serialization
         *
         * See more at file magento2root/lib/web/mage/adminhtml/grid.js
         */
        $this->_formScripts[] = "
			require(['jquery'], function($){
				window.openItemPopupWindow = function (url) {
					var left = ($(document).width()-1000)/2, height= $(document).height();
					var create_item_popupwindow = window.open(url, '_blank','width=1000,resizable=1,scrollbars=1,toolbar=1,'+'left='+left+',height='+height);
					var windowFocusHandle = function(){
						if (create_item_popupwindow.closed) {
							if (typeof itemGridJsObject !== 'undefined' && create_item_popupwindow.id) {
								itemGridJsObject.reloadParams['item[]'].push(create_item_popupwindow.id + '');
								$(edit_form.carousel_item).val($(edit_form.carousel_item).val() + '&' + create_item_popupwindow.id + '=' + Base64.encode('sort_order=0'));
				       			itemGridJsObject.setPage(create_item_popupwindow.id);
				       		}
				       		$(window).off('focus',windowFocusHandle);
						} else {
							$(create_item_popupwindow).trigger('focus');
							create_item_popupwindow.alert('" . __('You have to save item and close this window!') . "');
						}
					}
					$(window).focus(windowFocusHandle);
				}
			});
		";
    }


    /**
     * Get carousel.
     *
     * @return mixed
     */
    public function getCarousel()
    {
        return $this->coreRegistry->registry('carousel');
    }

    /**
     * Get save and continue url.
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl(
            '*/*/save',
            ['_current' => true, 'back' => 'edit', 'tab' => '{{tab_id}}']
        );
    }

    /**
     * Get create item url.
     *
     * @return string
     */
    public function getCreateItemUrl()
    {
        return $this->getUrl('*/item/new', ['current_carousel_id' => $this->getCarousel()->getId()]);
    }
}
