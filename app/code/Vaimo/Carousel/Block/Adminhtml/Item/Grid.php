<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Item;

use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory;
use Vaimo\Carousel\Model\Status;

class Grid extends Extended
{
    /**
     * Item collection factory.
     *
     * @var CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * Carousel collection factory.
     *
     * @var \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory
     */
    protected $carouselCollectionFactory;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param CollectionFactory $itemCollectionFactory
     * @param \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $itemCollectionFactory,
        \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory,
        array $data = []
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->carouselCollectionFactory = $carouselCollectionFactory;

        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('itemGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    /**
     * Prepare collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        $storeViewId = $this->getRequest()->getParam('store');

        /** @var \Vaimo\Carousel\Model\ResourceModel\Item\Collection $collection */
        $collection = $this->itemCollectionFactory->create()->setStoreViewId($storeViewId);

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare columns.
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'options' => Status::getAvailableStatuses(),
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'width' => '50px',
                'filter' => false,
                'renderer' => 'Vaimo\Carousel\Block\Adminhtml\Item\Helper\Renderer\Image',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'created_at',
            [
                'header' => __('Created'),
                'index' => 'created_at',
            ]
        );

        $this->addColumn(
            'updated_at',
            [
                'header' => __('Updated'),
                'index' => 'updated_at',
            ]
        );

        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => '*/*/edit'],
                        'field' => 'id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get carousel available option.
     *
     * @return array
     */
    public function getCarouselAvailableOption()
    {
        $option = [];
        $carouselCollection = $this->carouselCollectionFactory->create()->addFieldToSelect(['title']);

        foreach ($carouselCollection as $carousel) {
            $option[$carousel->getId()] = $carousel->getTitle();
        }

        return $option;
    }

    /**
     * Prepare mass-action.
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('item');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('vaimocarousel/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );

        $statuses = Status::getAvailableStatuses();

        array_unshift($statuses, ['label' => '', 'value' => '']);
        $this->getMassactionBlock()->addItem(
            'status',
            [
                'label' => __('Change status'),
                'url' => $this->getUrl('vaimocarousel/*/massStatus', ['_current' => true]),
                'additional' => [
                    'visibility' => [
                        'name' => 'status',
                        'type' => 'select',
                        'class' => 'required-entry',
                        'label' => __('Status'),
                        'values' => $statuses,
                    ],
                ],
            ]
        );

        return $this;
    }

    /**
     * Get grid url.
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }

    /**
     * Get row url.
     *
     * @param  object $row
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            ['id' => $row->getId()]
        );
    }
}
