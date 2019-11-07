<?php
/**
 * Copyright Vaimo Group. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Vaimo\Carousel\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * checks if column exists then it adds given fields to the table
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $tableNameItems = $setup->getTable('vaimo_carousel_items');
        $tableNameCarousels = $setup->getTable('vaimo_carousel_carousels');

        if (version_compare($context->getVersion(), '1.1.1', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameItems) == true) {
                $columns = [
                    'image_small' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Small Image',
                    ],
                    'image_medium' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                        'nullable' => true,
                        'comment' => 'Medium Image',
                    ]
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableNameItems, $name, $definition);
                }
            }
        }

        if (version_compare($context->getVersion(), '1.1.2', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameCarousels) == true) {
                $connection = $setup->getConnection();
                $connection->addColumn(
                    $tableNameCarousels,
                    'autoplay',
                    ['type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT, 'nullable' => true, 'default' => '0', 'afters' => 'dots', 'comment' => 'Autoplay']
                );
            }
        }

        if (version_compare($context->getVersion(), '1.1.3', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameCarousels) == true) {
                $columns = [
                    'autoplay_timeout' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'Autoplay Timeout',
                    ],
                    'autoplay_hover_pause' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'nullable' => true,
                        'default' => '0',
                        'comment' => 'Autoplay Hover Pause',
                    ]
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableNameCarousels, $name, $definition);
                }
            }
        }

        if (version_compare($context->getVersion(), '1.2.0', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameItems) == true) {
                $columns = [
                    'theme' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                        'nullable' => true,
                        'comment' => 'Dark/Light/etc theme',
                    ]
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableNameItems, $name, $definition);
                }
            }
        }

        if (version_compare($context->getVersion(), '1.2.1', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameItems) == true) {
                $columns = [
                    'content_position_vertical' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'Content Position Vertical',
                    ],
                    'content_width' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'Content Width',
                    ]
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableNameItems, $name, $definition);
                }
            }
        }

        if (version_compare($context->getVersion(), '1.2.2', '<')) {
            if ($setup->getConnection()->isTableExists($tableNameItems) == true) {
                $columns = [
                    'font_size_title' => [
                        'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                        'nullable' => true,
                        'comment' => 'Font size for item title',
                    ]
                ];

                $connection = $setup->getConnection();
                foreach ($columns as $name => $definition) {
                    $connection->addColumn($tableNameItems, $name, $definition);
                }
            }
        }

        $setup->endSetup();
    }
}
