<?php

namespace Vaimo\Quote\Model;

use Magento\Framework\Model\AbstractModel;
use Vaimo\Quote\Model\ResourceModel\Quote as ResourceModel;
use Vaimo\Quote\Api\Data\QuoteInterface;

    class Quote extends AbstractModel implements QuoteInterface
    {
        protected function _construct()
        {
            $this->_init(ResourceModel::class);
        }
        public function getId()
        {
            return $this->getData(QuoteInterface::ID_FIELD);
        }
    }