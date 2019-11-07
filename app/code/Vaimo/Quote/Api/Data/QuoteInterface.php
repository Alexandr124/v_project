<?php


namespace Vaimo\Quote\Api\Data;
interface QuoteInterface
{
    const TABLE_NAME                = 'vaimo_quote';
    const ID_FIELD                  = 'id';

    public function getId();

}