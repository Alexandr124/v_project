<?php


namespace Vaimo\Quote\Api\Data;

interface QuoteInterface
{
    const TABLE_NAME                = 'vaimo_quote';
    const ID_FIELD                  = 'id';
    const FIRST_NAME                = 'first_name';
    const LAST_NAME                 = 'last_name';
    const PHONE_NUMBER              = 'phone_number';
    const QUOTE_STATUS              = 'quote_status';

    public function getId();

    public function getFirstName();

    public function setFirstName($first_name);

    public function getLastName();

    public function setLastName($name);

    public function getPhoneNumber();

    public function setPhoneNumber($number);

    public function getQuoteStatus();

    public function setQuoteStatus($status);

}