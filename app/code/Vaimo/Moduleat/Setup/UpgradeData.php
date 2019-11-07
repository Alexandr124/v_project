<?php

namespace Vaimo\Moduleat\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
/**
* {@inheritdoc}
* @SuppressWarnings(PHPMD.ExcessiveMethodLength)
*/

    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */

    /**
     * Eav setup factory
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
    /**
     * Init
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(\Magento\Eav\Setup\EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
    $setup->startSetup();

    if ($context->getVersion()
    && version_compare($context->getVersion(), '1.0.4') < 0
        ) {
            $table = $setup->getTable('vaimo_moduleat');
            $setup->getConnection()
            ->insertForce($table, ['Material' => 'new_matterial']);

        //    $setup->getConnection()
        //    ->update($table, ['name' => 'winter'], 'greeting_id IN (1,2)');

        }

        $eavSetup = $this->eavSetupFactory->create();
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'clothing_material2',
            [
                'group' => 'General',
                'type' => 'varchar',
                'label' => 'Clothing Material2',
                'input' => 'select',
                'source' => '',
                'frontend' => '',
                'backend' => '',
                'required' => false,
                'sort_order' => 50,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'is_used_in_grid' => false,
                'is_visible_in_grid' => false,
                'is_filterable_in_grid' => false,
                'visible' => true,
                'is_html_allowed_on_front' => true,
                'visible_on_front' => true
            ]
        );

    $setup->endSetup();
    }
}