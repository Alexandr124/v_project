<?php

namespace Vaimo\Helloworld\Block;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Helper\Data;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\Stdlib\DateTime\DateTime;


class MostViewedProducts extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Reports\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productsFactory;

    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Reports\Model\ResourceModel\Product\CollectionFactory $productsFactory,
        array $data = []
    ) {
        $this->_productsFactory = $productsFactory;
        parent::__construct($context, $data);
    }

    /**
     * Getting most viewed products
     */
    public function getCollection()
    {

        $currentStoreId = $this->_storeManager->getStore()->getId();

        $collection = $this->_productsFactory->create()
            ->addAttributeToSelect(
                '*'
            )->addViewsCount()->setStoreId(
                $currentStoreId
            )->addStoreFilter(
                $currentStoreId
            );
        $items = $collection->getItems();
        return $items;
    }

    public function getProductCount($id)
    {
        /**
         * @var \Magento\Catalog\Model\Product\Interceptor $product
         */
        //Get Object Manager Instance
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        //Load product by product id
        $productObj = $objectManager->create('Magento\Catalog\Model\Product')->load($id);
        $productcollection = $objectManager->create('\Magento\Reports\Model\ResourceModel\Product\Collection');
        $productcollection->setProductAttributeSetId($productObj->getAttributeSetId());
        $prodData = $productcollection->addViewsCount()->getData();

        if (count($prodData) > 0) {
            foreach ($prodData as $product) {
                if ($product['entity_id'] == $id) {
                    return (int) $product['views'];
                }
            }
        }

        return 0;
    }
}