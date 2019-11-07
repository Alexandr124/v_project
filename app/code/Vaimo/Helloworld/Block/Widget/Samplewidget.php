<?php
namespace Vaimo\Helloworld\Block\Widget;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Samplewidget extends Template implements BlockInterface
{
    protected $_template = "widget/samplewidget.phtml";

    const PATH__INSTA = 'vaimo_customs/socials/instagram';
    const PATH__FB = 'vaimo_customs/socials/facebook';
    const PATH__TELEGRAM = 'vaimo_customs/socials/telegram';

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

    public function getScoupeConfigInsta()
    {
        return $this->scopeConfig->getValue($this::PATH__INSTA);
    }

    public function getScoupeConfigFB()
    {
        return $this->scopeConfig->getValue($this::PATH__FB);
    }

    public function getScoupeConfigTelegram()
    {
        return $this->scopeConfig->getValue($this::PATH__TELEGRAM);
    }

}