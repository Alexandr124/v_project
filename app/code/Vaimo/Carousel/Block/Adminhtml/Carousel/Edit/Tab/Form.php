<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Tab\TabInterface;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Vaimo\Carousel\Helper\Data;
use Vaimo\Carousel\Model\Status;

class Form extends Generic implements TabInterface
{
    const FIELD_NAME_SUFFIX = 'carousel';

    /**
     * Core registry.
     *
     * @var coreRegistry
     */
    protected $coreRegistry;
    
    /**
     * @var \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory
     */
    protected $fieldFactory;

    /**
     * @var Data
     */
    protected $carouselItemHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param Data $carouselItemHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Data $carouselItemHelper,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->carouselItemHelper = $carouselItemHelper;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare layout.
     *
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $carousel = $this->getCarousel();
        $isElementDisabled = true;
        
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Carousel Details')]);

        if ($carousel->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $fieldset->addField('title', 'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
                'class' => 'required-entry'
            ]
        );

        $fieldset->addField('status', 'select',
            [
                'label' => __('Status'),
                'title' => __('Status'),
                'name' => 'status',
                'options' => Status::getAvailableStatuses(),
                'disabled' => false,
                'required' => false,
            ]
        );

        $fieldset->addField('nav', 'select',
            [
                'name' => 'nav',
                'label' => __('Arrows'),
                'title' => __('Arrows'),
                'required' => false,
                'values' => [
                    ['value' => 1, 'label' => __('Enable')],
                    ['value' => 0, 'label' => __('Disable')]
                ],
                'note' => __('Enable or disable navigation arrows'),
            ]
        );

        $fieldset->addField('dots', 'select',
            [
                'name' => 'dots',
                'label' => __('Dots'),
                'title' => __('Dots'),
                'required' => false,
                'values' => [
                    ['value' => 1, 'label' => __('Enable')],
                    ['value' => 0, 'label' => __('Disable')]
                ],
                'note' => __('Enable or disable navigation dots'),
            ]
        );

        $fieldset->addField('autoplay', 'select',
            [
                'name' => 'autoplay',
                'label' => __('Autoplay'),
                'title' => __('Autoplay'),
                'required' => false,
                'values' => [
                    ['value' => 1, 'label' => __('Enable')],
                    ['value' => 0, 'label' => __('Disable')]
                ]
            ]
        );

        $fieldset->addField('autoplay_timeout', 'text',
            [
                'name' => 'autoplay_timeout',
                'label' => __('Autoplay Timeout'),
                'title' => __('Autoplay Timeout'),
                'required' => false,
                'note' => __('Autoplay interval timeout in millisecond. If left empty, the default is 5000'),
            ]
        );

        $fieldset->addField('autoplay_hover_pause', 'select',
            [
                'name' => 'autoplay_hover_pause',
                'label' => __('Autoplay Hover Pause'),
                'title' => __('Autoplay Hover Pause'),
                'required' => false,
                'values' => [
                    ['value' => 1, 'label' => __('Yes')],
                    ['value' => 0, 'label' => __('No')]
                ],
                'note' => __('Pause on mouse hover'),
            ]
        );

        $fieldset->addField('number_of_visible_items', 'text',
            [
                'name' => 'number_of_visible_items',
                'label' => __('Number of Visible Items'),
                'title' => __('Number of Visible Items'),
                'required' => false,
                'note' => __('The number of items you want to see on the screen at the same time'),
            ]
        );

        if (!$carousel->getId()) {
            $carousel->setStatus($isElementDisabled ? Status::STATUS_ENABLED : Status::STATUS_DISABLED);
        }

        $form->setValues($carousel->getData());
        $form->addFieldNameSuffix(self::FIELD_NAME_SUFFIX);
        $this->setForm($form);

        return parent::_prepareForm();
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
     * Get page title.
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->getCarousel()->getId() ? __("Edit Carousel '%1'",
            $this->escapeHtml($this->getCarousel()->getTitle())) : __('New Carousel');
    }

    /**
     * Get tab label.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Carousel Details');
    }

    /**
     * Get tab title.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Carousel Details');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
