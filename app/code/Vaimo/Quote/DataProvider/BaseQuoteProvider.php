<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-07
 * Time: 11:50
 */

namespace Vaimo\Quote\DataProvider;


use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

class BaseQuoteProvider extends AbstractDataProvider
{

    private $sessionManager;
    public function __construct(CollectionFactory $collectionFactory,
                                SessionManagerInterface $sessionManager,
                                $name,
                                $primaryFieldName,
                                $requestFieldName,
                                array $meta = [], array
                                $data = [])
    {
       // $this->collection      =  $collectionFactory->create();
        $this->sessionManager  =  $sessionManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }
    /**
     * @return array
     */
    public function getData()
    {

    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {
        return null;
    }

}