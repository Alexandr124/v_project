<?php
namespace Vaimo\Helloworld\Block;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;



class DynamicBlock extends \Magento\Framework\View\Element\Template
{


    public function __construct(\Magento\Catalog\Model\ProductRepository $productRepository, Template\Context $context, array $data = [])
    {

        parent::__construct($context, $data);

         $this->productRepository = $productRepository;
    }

    public function getProduct($productId){

        $tempProduct = $this->productRepository->getById($productId);
        $tempProduct->setData('name', "Custom name");
        $this->productRepository->save($tempProduct);
        return $tempProduct;
    }

}