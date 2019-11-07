<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Form\Renderer\Fieldset;

class Element extends \Magento\Backend\Block\Widget\Form\Renderer\Fieldset\Element
{
    /**
     * Initialize block template.
     */
    protected $template = 'Vaimo_Carousel::form/renderer/fieldset/element.phtml';

    /**
     * Get element name.
     *
     * @return string
     */
    public function getElementName()
    {
        return $this->getElement()->getName();
    }

    /**
     * Get element store view id.
     *
     * @return string
     */
    public function getElementStoreViewId()
    {
        return $this->getElement()->getStoreViewId();
    }

    /**
     * Check "Use default" checkbox display availability.
     *
     * @return bool
     */
    public function canDisplayUseDefault()
    {
        return ($this->getRequest()->getParam('store') && $this->getElement()->getDateFormat() == null
            && $this->getElementName() != 'carousel_id') ? true : false;
    }

    /**
     * Check default value usage fact.
     *
     * @return bool
     */
    public function usedDefault()
    {
        return $this->getElementStoreViewId() ? false : true;
    }

    /**
     * Disable field in default value using case.
     *
     * @return $this
     */
    public function checkFieldDisable()
    {
        if (!$this->getElementStoreViewId() && $this->getElementName() != 'item_id'
            && $this->canDisplayUseDefault() && $this->usedDefault()) {
            $this->getElement()->setDisabled(true);
        }

        return $this;
    }

    /**
     * Get scope label.
     *
     * @return string
     */
    public function getScopeLabel()
    {
        $storeViewFields = [
            'status',
        ];

        if (in_array($this->getElementName(), $storeViewFields)) {
            return '[STORE VIEW]';
        }

        return '[GLOBAL]';
    }

    /**
     * Get element label html.
     *
     * @return string
     */
    public function getElementLabelHtml()
    {
        $element = $this->getElement();
        $label = $element->getLabel();

        if (!empty($label)) {
            $element->setLabel(__($label));
        }

        return $element->getLabelHtml();
    }

    /**
     * Get element html.
     *
     * @return string
     */
    public function getElementHtml()
    {
        return $this->getElement()->getElementHtml();
    }

    /**
     * Get default store id.
     *
     * @return int
     */
    protected function getDefaultStoreId()
    {
        return \Magento\Store\Model\Store::DEFAULT_STORE_ID;
    }
}
