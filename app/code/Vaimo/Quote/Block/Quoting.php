<?php

namespace Vaimo\Quote\Block;

class Quoting extends \Magento\Framework\View\Element\Template
{
    /**
     * Construct
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
    }

    /**
     * Get form action URL for POST booking request'
     *
     * @return string
     */
    public function getFormAction()
    {
        // companymodule is given in routes.xml
        return $this->getUrl('quote_form/index/quoting');
    }
}