<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Model;

use \Magento\Framework\Model\AbstractModel;

class Item extends AbstractModel
{
    const BASE_MEDIA_PATH = 'vaimo/carousel/images';
    const THEME_LIGHT = 0;
    const THEME_MEDIUM = 1;
    const THEME_DARK = 2;

    /**
     * Get available themes.
     *
     * @return array
     */
    public static function getAvailableThemes()
    {
        return [
            self::THEME_LIGHT => 'Light',
            self::THEME_MEDIUM => 'Medium',
            self::THEME_DARK => 'Dark',
        ];
    }

    /**
     * Carousel collection factory.
     *
     * @var \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory
     */
    protected $carouselCollectionFactory;

    /**
     * Store view id.
     *
     * @var int
     */
    protected $storeViewId = null;

    /**
     * @var string
     */
    protected $formFieldHtmlIdPrefix = 'page_';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\Logger\Monolog
     */
    protected $monolog;

    /**
     * @var \Vaimo\Carousel\Model\ItemFactory
     */
    protected $itemFactory;

    /**
     * @var \Vaimo\Carousel\Model\ValueFactory
     */
    protected $valueFactory;

    /**
     * @var \Vaimo\Carousel\Model\ResourceModel\Value\CollectionFactory
     */
    protected $valueCollectionFactory;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Vaimo\Carousel\Model\ResourceModel\Item $resource
     * @param \Vaimo\Carousel\Model\ResourceModel\Item\Collection $resourceCollection
     * @param \Vaimo\Carousel\Model\ItemFactory $itemFactory
     * @param \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory
     * @param \Vaimo\Carousel\Model\ResourceModel\Value\CollectionFactory $valueCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Vaimo\Carousel\Model\ResourceModel\Item $resource,
        \Vaimo\Carousel\Model\ResourceModel\Item\Collection $resourceCollection,
        \Vaimo\Carousel\Model\ItemFactory $itemFactory,
        \Vaimo\Carousel\Model\ValueFactory $valueFactory,
        \Vaimo\Carousel\Model\ResourceModel\Carousel\CollectionFactory $carouselCollectionFactory,
        \Vaimo\Carousel\Model\ResourceModel\Value\CollectionFactory $valueCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Logger\Monolog $monolog
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->itemFactory = $itemFactory;
        $this->valueFactory = $valueFactory;
        $this->valueCollectionFactory = $valueCollectionFactory;
        $this->storeManager = $storeManager;
        $this->carouselCollectionFactory = $carouselCollectionFactory;
        $this->monolog = $monolog;

        if ($storeViewId = $this->storeManager->getStore()->getId()) {
            $this->storeViewId = $storeViewId;
        }
    }

    /**
     * Get form field html id prefix.
     *
     * @return string
     */
    public function getFormFieldHtmlIdPrefix()
    {
        return $this->formFieldHtmlIdPrefix;
    }

    /**
     * Get available carousels.
     *
     * @return array
     */
    public function getAvailableCarousels()
    {
        $option[] = [
            'value' => '',
            'label' => __('Select Carousel'),
        ];

        $carouselCollection = $this->carouselCollectionFactory->create();
        foreach ($carouselCollection as $carousel) {
            $option[] = [
                'value' => $carousel->getId(),
                'label' => $carousel->getTitle(),
            ];
        }

        return $option;
    }

    /**
     * Get available item type.
     *
     * @return array
     */
    public function getAvailableItemType()
    {
        $option[] = [
            'value' => 1,
            'label' => __('Image'),
        ];

        return $option;
    }

    /**
     * Get store attributes.
     *
     * @return array
     */
    public function getStoreAttributes()
    {
        return [
            'status',
        ];
    }

    /**
     * Get store view id.
     *
     * @return int
     */
    public function getStoreViewId()
    {
        return $this->storeViewId;
    }

    /**
     * Set store view id.
     *
     * @param int $storeViewId
     *
     * @return int
     */
    public function setStoreViewId($storeViewId)
    {
        $this->storeViewId = $storeViewId;

        return $this;
    }

    /**
     * Before save.
     */
    public function beforeSave()
    {
        if ($this->getStoreViewId()) {
            $defaultStore = $this->itemFactory->create()->setStoreViewId(null)->load($this->getId());
            $storeAttributes = $this->getStoreAttributes();
            $data = $this->getData();

            foreach ($storeAttributes as $attribute) {
                if (isset($data['use_default']) && isset($data['use_default'][$attribute])) {
                    $this->setData($attribute . '_in_store', false);
                } else {
                    $this->setData($attribute . '_in_store', true);
                    $this->setData($attribute . '_value', $this->getData($attribute));
                }
                $this->setData($attribute, $defaultStore->getData($attribute));
            }
        }

        return parent::beforeSave();
    }

    /**
     * After save.
     */
    public function afterSave()
    {

        if ($storeViewId = $this->getStoreViewId()) {
            $storeAttributes = $this->getStoreAttributes();

            foreach ($storeAttributes as $attribute) {
                $attributeValue = $this->valueFactory->create()
                    ->loadAttributeValue($this->getId(), $storeViewId, $attribute);
                if ($this->getData($attribute . '_in_store')) {

                    try {
                        if ($attribute == 'image' && $this->getData('delete_image')) {
                            $attributeValue->delete();
                        } else {
                            $attributeValue->setValue($this->getData($attribute . '_value'))->save();

                        }
                    } catch (\Exception $e) {
                        $this->monolog->addError($e->getMessage());
                    }
                } elseif ($attributeValue && $attributeValue->getId()) {
                    try {
                        $attributeValue->delete();
                    } catch (\Exception $e) {
                        $this->monolog->addError($e->getMessage());
                    }
                }
            }
        }

        return parent::afterSave();
    }

    /**
     * Load info multistore.
     *
     * @param mixed $id
     * @param string $field
     *
     * @return $this
     */
    public function load($id, $field = null)
    {
        parent::load($id, $field);
        if ($this->getStoreViewId()) {
            $this->getStoreViewValue();
        }

        return $this;
    }

    /**
     * Get store view value.
     *
     * @param string|null $storeViewId
     *
     * @return $this
     */
    public function getStoreViewValue($storeViewId = null)
    {
        if (!$storeViewId) {
            $storeViewId = $this->getStoreViewId();
        }
        if (!$storeViewId) {
            return $this;
        }
        $storeValues = $this->valueCollectionFactory->create()
            ->addFieldToFilter('item_id', $this->getId())
            ->addFieldToFilter('store_id', $storeViewId);
        foreach ($storeValues as $value) {
            $this->setData($value->getAttributeCode() . '_in_store', true);
            $this->setData($value->getAttributeCode(), $value->getValue());
        }

        return $this;
    }
}
