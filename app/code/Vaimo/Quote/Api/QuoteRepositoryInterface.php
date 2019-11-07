<?php

namespace Vaimo\Quote\Api;
interface QuoteRepositoryInterface
{

    public function getById($id);

    public function deleteById($id);

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    public function delete(\Vaimo\Quote\Api\Data\QuoteInterface $quote);
}