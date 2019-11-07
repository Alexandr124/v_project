<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        // Get vaimo_carousel_items table
        $tableName = $installer->getTable('vaimo_carousel_items');

        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {

            /**
             * Create table 'vaimo_carousel_items'
             */

            $table = $installer->getConnection()->newTable(
                $tableName
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Item Id'
            )
            ->addColumn('carousel_id', Table::TYPE_INTEGER, null, ['nullable' => true], 'Carousel Id')
            ->addColumn('item_type', Table::TYPE_SMALLINT, null, ['nullable' => true, 'default' => '0'], 'Item Type')
            ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => false, 'default' => '1'], 'Item Status')
            ->addColumn('title', Table::TYPE_TEXT, 255, [], 'Item Title')
            ->addColumn('text', Table::TYPE_TEXT, '64k', [],'Item Text')
            ->addColumn('item_url', Table::TYPE_TEXT, 255, ['nullable' => true, 'default' => ''], 'Item URL')
            ->addColumn('video', Table::TYPE_TEXT, '64k', ['nullable' => true, 'default' => ''], 'Item Video')
            ->addColumn('image', Table::TYPE_TEXT, 255, ['nullable' => true], 'Item Image')
            ->addColumn('custom', Table::TYPE_TEXT, '64k', ['nullable' => true, 'default' => ''],'Item Custom HTML')
            ->addColumn('alt_text', Table::TYPE_TEXT, 255, [],'Item Image Alt Text')
            ->addColumn('content_position', Table::TYPE_INTEGER, null, ['nullable' => false], 'Content position')
            ->addColumn('button_first_label', Table::TYPE_TEXT, 255, [], 'First button label')
            ->addColumn('button_first_url', Table::TYPE_TEXT, 255, [], 'First button url')
            ->addColumn('button_second_label', Table::TYPE_TEXT, 255, [], 'Second button label')
            ->addColumn('button_second_url', Table::TYPE_TEXT, 255, [], 'Second button url')
            ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Created at')
            ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Updated at')
            ->addColumn('sort_order', Table::TYPE_INTEGER, null, ['nullable' => true], 'Item Sort Order')
            ->addIndex($installer->getIdxName('vaimo_carousel_items', ['id']), ['id'])
            ->addIndex($installer->getIdxName('vaimo_carousel_items', ['status']), ['status'])
            ->addIndex($installer->getIdxName('vaimo_carousel_items', ['carousel_id']), ['carousel_id'])
            ->setComment('Vaimo Carousel Items Table');

            $installer->getConnection()->createTable($table);
        }

        /*
         * Create table vaimo_carousel_carousels
         */

        // Get vaimo_carousel_carousels table
        $tableName = $installer->getTable('vaimo_carousel_carousels');

        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()->newTable(
                $tableName
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'ID'
            )
            ->addColumn('status', Table::TYPE_SMALLINT, null, ['nullable' => true, 'default' => '0'], 'Carousel Status')
            ->addColumn('title', Table::TYPE_TEXT, 255, ['nullable' => false, 'default' => 'Custom Carousel'], 'Carousel Title')
            ->addColumn('carousel_content', Table::TYPE_TEXT, '64k', ['nullable' => true, 'default' => ''],'Carousel Content')
            ->addColumn('nav', Table::TYPE_SMALLINT, null, ['nullable' => true, 'default' => '1'], 'Navigation')
            ->addColumn('dots', Table::TYPE_SMALLINT, null, ['nullable' => true, 'default' => '1'], 'Dots')
            ->addColumn('number_of_visible_items', Table::TYPE_INTEGER, null, ['nullable' => true, 'default' => '1'], 'Number of Visible Items')
            ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [], 'Created at')
            ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [], 'Updated at')
            ->addIndex($installer->getIdxName('vaimo_carousel_carousels', ['id']),['status'])
            ->addIndex( $installer->getIdxName('vaimo_carousel_carousels', ['status']), ['status'])
            ->setComment('Vaimo Carousel table');

            $installer->getConnection()->createTable($table);
        }

        /*
         * Create table vaimo_carousel_value
         */

        // Get vaimo_carousel_value table
        $tableName = $installer->getTable('vaimo_carousel_value');

        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            $table = $installer->getConnection()->newTable(
                $tableName
            )->addColumn(
                'value_id',
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Value Id'
            )
            ->addColumn('item_id', Table::TYPE_INTEGER, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'], 'Item Id')
            ->addColumn('store_id', Table::TYPE_SMALLINT, null, ['unsigned' => true, 'nullable' => false, 'default' => '0'],'Store View Id')
            ->addColumn('attribute_code', Table::TYPE_TEXT, 64, ['nullable' => false, 'default' => ''], 'Attribute Code')
            ->addColumn('value', Table::TYPE_TEXT, null, ['nullable' => false], 'Value')
            ->addIndex(
                $installer->getIdxName('vaimo_carousel_value',
                ['item_id', 'store_id', 'attribute_code'],
                \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE),
                ['item_id', 'store_id', 'attribute_code'],
                ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addIndex($installer->getIdxName('vaimo_carousel_value', ['item_id']), ['item_id'])
            ->addIndex($installer->getIdxName('vaimo_carousel_value', ['store_id']), ['store_id'])
            ->addForeignKey(
                $installer->getFkName('vaimo_carousel_value','item_id', 'vaimo_carousel_items', 'id'),
                'item_id',
                $installer->getTable('vaimo_carousel_items'),
                'id',
                Table::ACTION_CASCADE
            )->addForeignKey(
                $installer->getFkName('vaimo_carousel_value', 'store_id', 'store', 'store_id'),
                'store_id',
                $installer->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            );
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}
