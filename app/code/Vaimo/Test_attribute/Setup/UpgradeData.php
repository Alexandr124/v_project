<?php

namespace Vaimo\Test_attribute\Setup;

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
    private $eavSetupFactory;


    /**
     * Upgrades data for a module
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */

public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
    $setup->startSetup();

    if ($context->getVersion()
    && version_compare($context->getVersion(), '1.0.2') < 0
        ) {
            $table = $setup->getTable('vaimo_testattribute');
            $setup->getConnection()
            ->insertForce($table, ['Material' => 'new_matterial']);

        //    $setup->getConnection()
        //    ->update($table, ['name' => 'winter'], 'greeting_id IN (1,2)');

        }

    $setup->endSetup();
    }
}