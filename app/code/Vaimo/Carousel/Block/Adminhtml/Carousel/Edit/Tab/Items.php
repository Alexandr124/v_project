<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block\Adminhtml\Carousel\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory;
use Vaimo\Carousel\Model\Status;

class Items extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * Item collection factory.
     *
     * @var CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param CollectionFactory $itemCollectionFactory
     * @param array $data
     */
    public function __construct(
        Context $context,
        Data $backendHelper,
        CollectionFactory $itemCollectionFactory,
        array $data = []
    ) {
        $this->itemCollectionFactory = $itemCollectionFactory;
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
        $this->setDefaultFilter(array('in_item' => 1));
    }

    /**
     * Add column filter to collection.
     *
     * @param \Magento\Backend\Block\Widget\Grid\Column $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_item') {

            $itemIds = $this->getSelectedItems() ?: 0;

            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('id', array('in' => $itemIds));
            } elseif ($itemIds) {
                $this->getCollection()->addFieldToFilter('id', array('nin' => $itemIds));
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    /**
     * Prepare collection.
     *
     * @return $this
     */
    protected function _prepareCollection()
    {
        /** @var \Vaimo\Carousel\Model\ResourceModel\Item\Collection $collection */
        $collection = $this->itemCollectionFactory->create()->setStoreViewId(null);
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
            'in_item',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_item',
                'align' => 'center',
                'index' => 'id',
                'values' => $this->getSelectedItems(),
            ]
        );

        $this->addColumn(
            'id',
            [
                'header' => __('Item ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Image'),
                'filter' => false,
                'width' => '50px',
                'renderer' => 'Vaimo\Carousel\Block\Adminhtml\Item\Helper\Renderer\Image',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Item Title'),
                'index' => 'title',
                'width' => '50px',
            ]
        );

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'options',
                'filter_index' => 'main_table.status',
                'options' => Status::getAvailableStatuses(),
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
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'renderer' => 'Vaimo\Carousel\Block\Adminhtml\Carousel\Edit\Tab\Helper\Renderer\EditItem',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );

        $this->addColumn(
            'sort_order',
            [
                'header' => __('Sort Order'),
                'name' => 'sort_order',
                'index' => 'sort_order',
                'width' => '50px',
                'editable' => true,
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Get grid url.
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/itemsgrid', ['_current' => true]);
    }

    /**
     * Get selected carousel items.
     *
     * @return array
     */
    public function getSelectedCarouselItems()
    {
        $carouselId = $this->getRequest()->getParam('id');
        if (!isset($carouselId)) {
            return [];
        }
        $itemCollection = $this->itemCollectionFactory->create();
        $itemCollection->addFieldToFilter('carousel_id', $carouselId);

        $itemIds = [];
        foreach ($itemCollection as $item) {
            $itemIds[$item->getId()] = ['sort_order' => $item->getSortOrder()];
        }

        return $itemIds;
    }

    /**
     * Get selected items.
     *
     * @return array|mixed
     */
    protected function getSelectedItems()
    {
        $items = $this->getRequest()->getParam('item');
        if (!is_array($items)) {
            $items = array_keys($this->getSelectedCarouselItems());
        }

        return $items;
    }

    /**
     * Get tab label.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Items');
    }

    /**
     * Get tab title.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Items');
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
        return true;
    }
}
