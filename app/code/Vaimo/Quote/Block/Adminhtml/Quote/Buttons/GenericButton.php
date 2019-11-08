<?php

namespace Mytest\Elevator\Block\Adminhtml\Elevator\Buttons;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

use Vaimo\Quote\Api\QuoteRepositoryInterface as Repository;

class GenericButton
{
    protected $context;
    protected $repository;
    public function __construct(
        Context $context,
        Repository $repository
    ) {
        $this->context = $context;
        $this->repository = $repository;
    }
    public function getOrderId()
    {
        try {
            return $this->repository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}