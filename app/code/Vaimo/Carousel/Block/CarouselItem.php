<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Block;

use Vaimo\Carousel\Model\Carousel as CarouselModel;
use Magento\Cms\Model\Template\FilterProvider;
use Vaimo\Carousel\Model\Item as Item;
use Vaimo\Carousel\Helper\FontSize;
use Magento\Framework\Registry;

class CarouselItem extends \Magento\Framework\View\Element\Template
{
    /**
     * Store manager.
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * Carousel factory.
     *
     * @var \Vaimo\Carousel\Model\CarouselFactory
     */
    protected $carouselFactory;

    /**
     * Carousel model.
     *
     * @var \Vaimo\Carousel\Model\Carousel
     */
    protected $carousel;

    /**
     * Carousel id.
     *
     * @var int
     */
    protected $carouselId;

    /**
     * Carousel item helper.
     *
     * @var \Vaimo\Carousel\Helper\Data
     */
    protected $carouselItemHelper;

    /**
     * Item collection factory.
     *
     * @var \Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory
     */
    protected $itemCollectionFactory;

    /**
     * Scope config.
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var FilterProvider
     */
    protected $filterProvider;

    /** @var  \Vaimo\Carousel\Model\Item */
    protected $item;

    /**
     * @var FontSize
     */
    protected $fontSizeHelper;

    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * CarouselItem constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory
     * @param \Vaimo\Carousel\Model\CarouselFactory $carouselFactory
     * @param CarouselModel $carousel
     * @param FilterProvider $filterProvider
     * @param \Vaimo\Carousel\Helper\Data $carouselItemHelper
     * @param Item $item
     * @param FontSize $fontSizeHelper
     * @param Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Vaimo\Carousel\Model\ResourceModel\Item\CollectionFactory $itemCollectionFactory,
        \Vaimo\Carousel\Model\CarouselFactory $carouselFactory,
        CarouselModel $carousel,
        FilterProvider $filterProvider,
        \Vaimo\Carousel\Helper\Data $carouselItemHelper,
        Item $item,
        FontSize $fontSizeHelper,
        Registry $registry,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->carouselFactory = $carouselFactory;
        $this->carousel = $carousel;
        $this->carouselItemHelper = $carouselItemHelper;
        $this->storeManager = $context->getStoreManager();
        $this->itemCollectionFactory = $itemCollectionFactory;
        $this->scopeConfig = $context->getScopeConfig();
        $this->filterProvider = $filterProvider;
        $this->item = $item;
        $this->fontSizeHelper = $fontSizeHelper;
        $this->registry = $registry;
    }

    /**
     * @param $id
     * @return string
     */
    public function getThemeClass($id)
    {
        $themes = $this->item::getAvailableThemes();
        $theme = isset($themes[$id]) ? $themes[$id] : '';
        $theme = empty($theme) ? '' : ' theme-' . strtolower($theme);
        return $theme;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        return parent::_toHtml();
    }

    /**
     * Set carousel id and template.
     *
     * @param int $carouselId
     *
     * @return $this
     */
    public function setCarouselId($carouselId)
    {
        $this->carouselId = $carouselId;
        $carousel = $this->carouselFactory->create()->load($this->carouselId);

        if ($carousel->getId()) {
            $this->setCarousel($carousel);
        }

        return $this;
    }

    /**
     * Get item collection.
     *
     * @return \Vaimo\Carousel\Model\ResourceModel\Item\Collection
     */
    public function getItemCollection()
    {
        $storeViewId = $this->storeManager->getStore()->getId();

        /** @var \Vaimo\Carousel\Model\ResourceModel\Item\Collection $itemCollection */
        $itemCollection = $this->itemCollectionFactory->create()
            ->setStoreViewId($storeViewId)
            ->addFieldToFilter('carousel_id', $this->carousel->getId())
            ->setOrder('sort_order', 'ASC');

        return $itemCollection;
    }

    /**
     * Get first carousel item.
     *
     * @return \Vaimo\Carousel\Model\Item
     */
    public function getFirstItem()
    {
        return $this->getItemCollection()
            ->getFirstItem();
    }

    /**
     * Set carousel model.
     *
     * @param \Vaimo\Carousel\Model\Carousel $carousel
     *
     * @return $this
     */
    public function setCarousel(\Vaimo\Carousel\Model\Carousel $carousel)
    {
        $this->carousel = $carousel;

        return $this;
    }

    /**
     * Get carousel.
     *
     * @return \Vaimo\Carousel\Model\Carousel
     */
    public function getCarousel()
    {
        return $this->carousel;
    }

    /**
     * Get item image url.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getItemImageUrl(\Vaimo\Carousel\Model\Item $item)
    {
        return $this->carouselItemHelper->getBaseUrlMedia($item->getImage());
    }

    /**
     * Get item image url for medium sized image.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getItemImageMediumUrl(\Vaimo\Carousel\Model\Item $item)
    {
        return $this->carouselItemHelper->getBaseUrlMedia($item->getImageMedium());
    }

    /**
     * Get item image url for small sized image.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getItemImageSmallUrl(\Vaimo\Carousel\Model\Item $item)
    {
        return $this->carouselItemHelper->getBaseUrlMedia($item->getImageSmall());
    }

    /**
     * Get item content position.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getItemContentPosition(\Vaimo\Carousel\Model\Item $item)
    {
        switch ($item->getContentPosition()) {
            case 1:
                $contentPosition = 'left';
                break;
            case 2:
                $contentPosition = 'center';
                break;
            case 3:
                $contentPosition = 'right';
                break;
            case 4:
                $contentPosition = 'full-width';
                break;
            default:
                $contentPosition = 'center';
        }

        return $contentPosition;
    }

    /**
     * Get item vertical content position.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getItemContentPositionVertical(\Vaimo\Carousel\Model\Item $item)
    {
        switch ($item->getContentPositionVertical()) {
            case 1:
                $contentPosition = 'top';
                break;
            case 2:
                $contentPosition = 'middle';
                break;
            case 3:
                $contentPosition = 'bottom';
                break;
            default:
                $contentPosition = 'middle';
        }

        return $contentPosition;
    }

    /**
     * Return the content width
     *
     * @param Item $item
     *
     * @return mixed
     */
    public function getItemContentWidth(\Vaimo\Carousel\Model\Item $item)
    {
        $contentWidth = $item->getContentWidth();
        if ($contentWidth) {
            return $contentWidth;
        }

        return false;
    }

    /**
     * Get item content text.
     *
     * @param \Vaimo\Carousel\Model\Item $item
     *
     * @return string
     */
    public function getCarouselItemText(\Vaimo\Carousel\Model\Item $item)
    {
        $itemText = $item->getText();
        if ($itemText) {
            return $this->getHtmlText($itemText);
        } else {
            return '';
        }
    }

    /**
     * Turn html string into html node
     * @param $text
     */
    public function getHtmlText($text)
    {
        return $this->filterProvider->getPageFilter()->filter($text);
    }

    /**
     * Get use dots.
     *
     * @return bool
     */
    public function getUseDots()
    {
        return (bool)$this->getCarousel()->getDots();
    }

    /**
     * Get use nav.
     *
     * @return bool
     */
    public function getUseNav()
    {
        return (bool)$this->getCarousel()->getNav();
    }

    /**
     * Get the number of items shown in the carousel at the same time.
     *
     * @return mixed
     */
    public function getNumberOfVisibleItems()
    {
        return $this->getCarousel()->getNumberOfVisibleItems();
    }

    /**
     * Get carousel autoplay option.
     *
     * @return bool
     */
    public function isAutoplay()
    {
        return (bool)$this->getCarousel()->getAutoplay();
    }

    /**
     * Get carousel autoplayHoverPause option.
     *
     * @return bool
     */
    public function isAutoplayHoverPause()
    {
        return (bool)$this->getCarousel()->getAutoplayHoverPause();
    }

    /**
     * Get carousel autoplayTimeout option.
     *
     * @return int
     */
    public function getAutoplayTimeout()
    {
        return $this->getCarousel()->getAutoplayTimeout();
    }

    /**
     * @param string $fontSize
     * @return string
     */
    public function getStyleFontSizeTitle($fontSize)
    {
        return $this->fontSizeHelper->getClass($fontSize);
    }

    /**
     * Different styling for anchor category
     *
     * @return bool
     */
    public function isCategoryAnchor()
    {
        $category = $this->registry->registry('current_category');
        if ($category && $category->getIsAnchor()) {
            return true;
        }

        return false;
    }
}
