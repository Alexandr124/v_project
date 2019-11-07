<?php
namespace Vaimo\Customs\Block;


use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;


class CustomBlock extends \Magento\Framework\View\Element\Template
{

    const CONFIG_CATEGORIES_PATH     = 'vaimo_customs/kit_prices/startup';

    private $scopeConfig;

    public function __construct(ScopeConfigInterface $scopeConfig, Template\Context $context, array $data = [])
    {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    /**'
     * CustomBlock constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param Context $context
     * @param array $data
     */

    public function getScoupeConfig()
    {
        $result = $this->scopeConfig->getValue($this::CONFIG_CATEGORIES_PATH);

        return $result;
    }

    public function getHelloWorldTxt()
    {
        return 'Hello world!';
    }
}