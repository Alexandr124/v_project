<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Helper;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\Store as StoreModal;
use Magento\Store\Model\StoreManagerInterface as StoreManagerInterface;

class Data extends AbstractHelper
{
    /**
     * @var UrlInterface
     */
    protected $backendUrl;

    protected $storeManager;

    /** @var StoreModal $storeModel */
    protected $storeModel;

    /**
     * @param Context $context
     * @param UrlInterface $backendUrl
     * @param StoreManagerInterface $storeManager
     * @param StoreModal $storeModel
     */
    public function __construct(
        Context $context,
        UrlInterface $backendUrl,
        StoreManagerInterface $storeManager,
        StoreModal $storeModel
    ) {
        parent::__construct($context);
        $this->storeManager = $storeManager;
        $this->backendUrl = $backendUrl;
        $this->storeModel = $storeModel;
    }

    /**
     * Get carousel item url.
     *
     * @return string
     */
    public function getCarouselItemUrl()
    {
        return $this->backendUrl->getUrl('*/*/items', ['_current' => true]);
    }

    /**
     * Get base url media.
     *
     * @param string $path
     *
     * @return string
     */
    public function getBaseUrlMedia($path = '')
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $this->storeModel->isFrontUrlSecure())
        . $path;
    }
}
