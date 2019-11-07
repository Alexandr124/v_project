<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\StoreManagerInterface;
use Vaimo\Carousel\Model\CarouselFactory;
use Vaimo\Carousel\Model\ItemFactory;
use Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory;

abstract class AbstractAction extends \Magento\Backend\App\Action
{
    const PARAM_CRUD_ID = 'id';

    /**
     * @var Js
     */
    protected $jsHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ForwardFactory
     */
    protected $resultForwardFactory;

    /**
     * @var LayoutFactory
     */
    protected $resultLayoutFactory;

    /**
     * A factory that knows how to create a "page" result
     * Requires an instance of controller action in order to impose page type,
     * which is by convention is determined from the controller action class
     *
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Item factory.
     *
     * @var ItemFactory
     */
    protected $itemFactory;

    /**
     * Carousel factory.
     *
     * @var CarouselFactory
     */
    protected $carouselFactory;

    /**
     * Item Collection Factory.
     *
     * @var CollectionFactory
     */
    protected $itemCollectionFactory;
    /**
     * Item Collection Factory.
     *
     * @var \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory
     */
    protected $carouselCollectionFactory;

    /**
     * Registry object.
     *
     * @var Registry
     */
    protected $registry;

    /**
     * File Factory.
     *
     * @var FileFactory
     */
    protected $fileFactory;

    /**
     * @param Context $context
     * @param ItemFactory $itemFactory
     * @param CarouselFactory $carouselFactory
     * @param CollectionFactory $itemCollectionFactory
     * @param \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory
     * @param Registry $registry
     * @param FileFactory $fileFactory
     * @param PageFactory $resultPageFactory
     * @param LayoutFactory $resultLayoutFactory
     * @param ForwardFactory $resultForwardFactory
     * @param StoreManagerInterface $storeManager
     * @param Js $jsHelper
     */
    public function __construct(
        Context $context,
        ItemFactory $itemFactory,
        CarouselFactory $carouselFactory,
        CollectionFactory $itemCollectionFactory,
        \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory,
        Registry $registry,
        FileFactory $fileFactory,
        PageFactory $resultPageFactory,
        LayoutFactory $resultLayoutFactory,
        ForwardFactory $resultForwardFactory,
        StoreManagerInterface $storeManager,
        Js $jsHelper
    ) {
        parent::__construct($context);
        $this->registry = $registry;
        $this->fileFactory = $fileFactory;
        $this->storeManager = $storeManager;
        $this->jsHelper = $jsHelper;

        $this->resultPageFactory = $resultPageFactory;
        $this->resultLayoutFactory = $resultLayoutFactory;
        $this->resultForwardFactory = $resultForwardFactory;

        $this->itemFactory = $itemFactory;
        $this->carouselFactory = $carouselFactory;
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->carouselCollectionFactory = $carouselCollectionFactory;
    }

    /**
     * Get back result redirect after add/edit action.
     *
     * @param Redirect $resultRedirect
     * @param null $paramCrudId
     *
     * @return Redirect
     */
    protected function getBackResultRedirect(Redirect $resultRedirect, $paramCrudId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
