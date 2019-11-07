<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Item\Edit\Tab;

use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\DataObjectFactory;
use Magento\Framework\Registry;
use Magento\Cms\Model\Wysiwyg\Config as WysiwygConfig;
use Vaimo\Carousel\Model\CarouselFactory;
use Vaimo\Carousel\Model\ResourceModel\Value\CollectionFactory;
use Vaimo\Carousel\Model\Status;

class Item extends Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * Core registry.
     *
     * @var coreRegistry
     */
    protected $coreRegistry;

    /**
     * @var DataObjectFactory
     */
    protected $objectFactory;

    /**
     * Value collection factory.
     *
     * @var CollectionFactory
     */
    protected $valueCollectionFactory;

    /**
     * Carousel factory.
     *
     * @var CarouselFactory
     */
    protected $carouselFactory;

    /**
     * @var \Vaimo\Carousel\Model\Item
     */
    protected $item;

    /**
     * @var WysiwygConfig
     */
    protected $wysiwygConfig;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param DataObjectFactory $objectFactory
     * @param WysiwygConfig $wysiwygConfig
     * @param \Vaimo\Carousel\Model\Item $item
     * @param CollectionFactory $valueCollectionFactory
     * @param CarouselFactory $carouselFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        DataObjectFactory $objectFactory,
        WysiwygConfig $wysiwygConfig,
        \Vaimo\Carousel\Model\Item $item,
        CollectionFactory $valueCollectionFactory,
        CarouselFactory $carouselFactory,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        $this->objectFactory = $objectFactory;
        $this->wysiwygConfig = $wysiwygConfig;
        $this->item = $item;
        $this->valueCollectionFactory = $valueCollectionFactory;
        $this->carouselFactory = $carouselFactory;
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

        \Magento\Framework\Data\Form::setFieldsetElementRenderer(
            $this->getLayout()->createBlock(
                'Vaimo\Carousel\Block\Adminhtml\Form\Renderer\Fieldset\Element',
                $this->getNameInLayout() . '_fieldset_element'
            )
        );

        return $this;
    }

    /**
     * Prepare form.
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        $itemAttributes = $this->item->getStoreAttributes();
        $itemAttributesInStores = ['store_id' => ''];

        foreach ($itemAttributes as $itemAttribute) {
            $itemAttributesInStores[$itemAttribute . '_in_store'] = '';
        }

        $dataObj = $this->objectFactory->create(
            ['data' => $itemAttributesInStores]
        );

        $model = $this->coreRegistry->registry('item');

        if ($carouselId = $this->getRequest()->getParam('current_carousel_id')) {
            $model->setCarouselId($carouselId);
        }

        $dataObj->addData($model->getData());

        $storeViewId = $this->getRequest()->getParam('store');

        $attributesInStore = $this->valueCollectionFactory
            ->create()
            ->addFieldToFilter('item_id', $model->getId())
            ->addFieldToFilter('store_id', $storeViewId)
            ->getColumnValues('attribute_code');

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix($this->item->getFormFieldHtmlIdPrefix());

        $htmlIdPrefix = $form->getHtmlIdPrefix();

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Item Details')]);

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', ['name' => 'id']);
        }

        $elements = [];

        $editorConfig = $this->wysiwygConfig->getConfig(['tab_id' => $this->getTabId()]);

        $carousel = $this->carouselFactory->create()->load($carouselId);

        if ($carousel->getId()) {
            $elements['carousel_id'] = $fieldset->addField(
                'carousel_id',
                'select',
                [
                    'label' => __('Carousel'),
                    'name' => 'carousel_id',
                    'required' => false,
                    'values' => [
                        [
                            'value' => $carousel->getId(),
                            'label' => $carousel->getTitle(),
                        ],
                    ],
                ]
            );
        } else {
            $elements['carousel_id'] = $fieldset->addField(
                'carousel_id',
                'select',
                [
                    'label' => __('Carousel'),
                    'name' => 'carousel_id',
                    'required' => false,
                    'values' => $model->getAvailableCarousels(),
                ]
            );
        }

        $elements['status'] = $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Status'),
                'title' => __('Item Status'),
                'name' => 'status',
                'required' => false,
                'options' => Status::getAvailableStatuses(),
            ]
        );

        $elements['theme'] = $fieldset->addField(
            'theme',
            'select',
            [
                'label' => __('Theme'),
                'title' => __('Theme'),
                'name' => 'theme',
                'required' => false,
                'options' => $this->item::getAvailableThemes(),
            ]
        );

        $elements['title'] = $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => false,
                'note' => __('Leave empty if not used'),
            ]
        );

        $elements['font_size_title'] = $fieldset->addField(
            'font_size_title',
            'select',
            [
                'name' => 'font_size_title',
                'label' => __('Font Size'),
                'title' => __('Font Size'),
                'options' => \Vaimo\Carousel\Helper\FontSize::getOptionLabel(),
                'required' => false,
            ]
        );

        $elements['item_type'] = $fieldset->addField(
            'item_type',
            'select',
            [
                'label' => __('Type'),
                'name' => 'item_type',
                'values' => $model->getAvailableItemType(),
                'required' => false,
            ]
        );

        $elements['image'] = $fieldset->addField(
            'image',
            'image',
            [
                'title' => __('Image'),
                'label' => __('Image'),
                'name' => 'image',
                'note' => __('Allowed image types: jpg, jpeg, gif, png'),
                'required' => true,
            ]
        );

        $elements['image_medium'] = $fieldset->addField(
            'image_medium',
            'image',
            [
                'title' => __('Medium Image'),
                'label' => __('Medium Image'),
                'name' => 'image_medium',
                'note' => __('Allowed image types: jpg, jpeg, gif, png'),
                'required' => false,
            ]
        );

        $elements['image_small'] = $fieldset->addField(
            'image_small',
            'image',
            [
                'title' => __('Small Image'),
                'label' => __('Small Image'),
                'name' => 'image_small',
                'note' => __('Allowed image types: jpg, jpeg, gif, png'),
                'required' => false,
            ]
        );

        $elements['url'] = $fieldset->addField(
            'item_url',
            'text',
            [
                'title' => __('URL'),
                'label' => __('URL'),
                'name' => 'item_url',
                'required' => false,
            ]
        );

        $elements['alt_text'] = $fieldset->addField(
            'alt_text',
            'text',
            [
                'title' => __('Alt Text'),
                'label' => __('Alt Text'),
                'name' => 'alt_text',
                'required' => false,
            ]
        );

        $elements['text'] = $fieldset->addField(
            'text',
            'editor',
            [
                'name' => 'text',
                'label' => __('Text'),
                'title' => __('Text'),
                'wysiwyg' => true,
                'required' => false,
                'style' => 'height:35em',
                'config' => $editorConfig,
                'note' => __('Leave empty if not used'),
            ]
        );

        $elements['content_width'] = $fieldset->addField(
            'content_width',
            'text',
            [
                'name' => 'content_width',
                'label' => __('Content Width (%)'),
                'title' => __('Content Width (%)'),
                'class' => 'validate-digits-range digits-range-0-100',
                'note' => __('Valid range 0-100')
            ],
            'input_validation'
        );

        $elements['content_position'] = $fieldset->addField(
            'content_position',
            'select',
            [
                'label' => __('Content position'),
                'name' => 'content_position',
                'options' => [
                    '1' => __('Left'),
                    '2' => __('Center'),
                    '3' => __('Right'),
                    '4' => __('Full-width')
                ],
                'required' => false
            ]
        );

        $elements['content_position_vertical'] = $fieldset->addField(
            'content_position_vertical',
            'select',
            [
                'label' => __('Content Vertical position'),
                'name' => 'content_position_vertical',
                'options' => [
                    '1' => __('Top'),
                    '2' => __('Middle'),
                    '3' => __('Bottom')
                ],
                'required' => false
            ]
        );

        $elements['button_first_label'] = $fieldset->addField(
            'button_first_label',
            'text',
            [
                'title' => __('First button label'),
                'label' => __('First button label'),
                'name' => 'button_first_label',
                'required' => false,
                'note' => __('Leave empty if not used'),
            ]
        );
        $elements['button_first_url'] = $fieldset->addField(
            'button_first_url',
            'text',
            [
                'title' => __('First button URL'),
                'label' => __('First button URL'),
                'name' => 'button_first_url',
                'required' => false,
                'note' => __('Leave empty if not used'),
            ]
        );
        $elements['button_second_label'] = $fieldset->addField(
            'button_second_label',
            'text',
            [
                'title' => __('Second button label'),
                'label' => __('Second button label'),
                'name' => 'button_second_label',
                'required' => false,
                'note' => __('Leave empty if not used'),
            ]
        );
        $elements['button_second_url'] = $fieldset->addField(
            'button_second_url',
            'text',
            [
                'title' => __('Second button URL'),
                'label' => __('Second button URL'),
                'name' => 'button_second_url',
                'required' => false,
                'note' => __('Leave empty if not used'),
            ]
        );

        foreach ($attributesInStore as $attribute) {
            if (isset($elements[$attribute])) {
                $elements[$attribute]->setStoreViewId($storeViewId);
            }
        }
        $form->addValues($dataObj->getData());

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Get item.
     *
     * @return mixed
     */
    public function getItem()
    {
        return $this->coreRegistry->registry('item');
    }

    /**
     * Get page title.
     *
     * @return string
     */
    public function getPageTitle()
    {
        return $this->getItem()->getId() ? __("Edit Item '%1'",
            $this->escapeHtml($this->getItem()->getTitle())) : __('New Item');
    }

    /**
     * Get tab label.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Item Details');
    }

    /**
     * Get tab title.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Item Details');
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
