<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-07
 * Time: 14:56
 */

namespace Vaimo\Quote\Model\Category\Attribute\Source;


class category implements \Magento\Framework\Option\ArrayInterface
{
    //Below function is supposed to return options.
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => 'pending'],
            ['value' => 2, 'label' => 'open'],
            ['value' => 3, 'label' => 'closed']
        ];
    }
}