<?php
/**
 * Created by PhpStorm.
 * User: alexander
 * Date: 2019-11-06
 * Time: 09:34
 */

namespace Vaimo\Quote\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

use Vaimo\Quote\Api\Data\QuoteInterface;
use Vaimo\Quote\Api\QuoteRepositoryInterface;
use Vaimo\Quote\Model\ResourceModel\Quote as ResourceModel;
use Vaimo\Quote\Model\QuoteFactory;
use Vaimo\Quote\Model\ResourceModel\Quote\CollectionFactory;


class QuoteRepository implements QuoteRepositoryInterface
{

    /** @var ResourceModel */
    protected $resource;
    /** @var QuoteFactory  */
    protected $quoteFactory;
    /** @var CollectionProcessorInterface */
    protected $collectionProcessor;
    /** @var CollectionFactory */
    protected $collectionFactory;

    public function __construct(
        ResourceModel $resource,
        QuoteFactory $quoteFactory,
        CollectionProcessorInterface $collectionProcessor,
        CollectionFactory $collectionFactory

    ) {
        $this->resource                 = $resource;
        $this->quoteFactory             = $quoteFactory;
        $this->collectionProcessor      = $collectionProcessor;
        $this->collectionFactory        = $collectionFactory;
    }



    public function getById($id)
    {
        $quote = $this->quoteFactory->create();
        $this->resource->load($quote, $id);
        if (!$quote->getId()) {
            throw new NoSuchEntityException(__('Quote with id "%1" does not exist.', $id));
        }
        return $quote;
    }

    public function deleteById($id)
    {
        try {
            $this->delete($this->getById($id));
        } catch (CouldNotDeleteException $e) {
        } catch (NoSuchEntityException $e) {
        }
    }

    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        // TODO: Implement getList() method.
    }

    public function save(\Vaimo\Quote\Api\Data\QuoteInterface $quote)
    {
        // TODO: Implement save() method.

    }
    /** {@inheritdoc} */
    public function delete(QuoteInterface $quote)
    {
        try {
            $this->resource->delete($quote);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return $this;
    }
}