<?php

namespace API\ProductAPI\Api;

use API\ProductAPI\Api\ProductSearchCriteriaInterface;
use API\ProductAPI\Api\Data\ProductSearchResultsInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Interface ProductRepositoryInterface
 */
interface ProductRepositoryInterface
{
    const FILTER_TYPE_TOP_SELLING = 'selling';
    const FILTER_TYPE_TOP_RATED   = 'rated';

    /**
     * Function getList
     *
     * @param string $type
     * @param ProductSearchCriteriaInterface $searchCriteria
     * @return ProductSearchResultsInterface
     * @throws LocalizedException
     */
    public function getList($type, ProductSearchCriteriaInterface $searchCriteria = null);
}
