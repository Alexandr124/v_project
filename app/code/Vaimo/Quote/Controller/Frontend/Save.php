<?php

namespace Vaimo\Quote\Controller\Adminhtml\Index;

use Psr\Log\LoggerInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\View\Result\Page;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Session\SessionManagerInterface;

use Vaimo\Quote\Api\Data\QuoteInterface;
use Vaimo\Quote\Model\QuoteFactory;
use Vaimo\Quote\Api\QuoteRepositoryInterface as Repository;

class Save
{
    const QUERY_PARAM_ID        = 'id';

    public function __construct(
        ResourceConnection $resource,
        Context $context,
        Registry $registry,
        PageFactory $pageFactory,
        SessionManagerInterface $sessionManager,
        Repository $repository,
        QuoteFactory $factory,
        LoggerInterface $logger
    ){
        $this->_resource      = $resource;
        $this->registry       = $registry;
        $this->pageFactory    = $pageFactory;
        $this->sessionManager  = $sessionManager;
        $this->repository     = $repository;
        $this->modelFactory   = $factory;
        $this->logger         = $logger;
        parent::__construct($context);
    }
    /**
     *
     */
    const TITLE = 'Quote Edit';
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam(static::QUERY_PARAM_ID);
        if (!empty($id)) {
            try {
                $model = $this->repository->getById($id);
                $this->sessionManager->setCurrentQuoteModel($model);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage(__('Entity with id %1 not found', $id));
                return $this->redirectToGrid();
            }
        } else {
            if($this->_getSession()->getFormData()){
                $model = $this->getModel();
                $model->setData($this->_getSession()->getFormData());
                $this->_getSession()->setFormData(null);
                $this->sessionManager->setCurrentQuoteModel($model);
            }
        }
        return parent::execute();
    }
}