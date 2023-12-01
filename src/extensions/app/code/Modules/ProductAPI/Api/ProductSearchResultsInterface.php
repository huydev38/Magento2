<?php

namespace Modules\ProductAPI\Api;

use Magento\Framework\Api\SearchResultsInterface;
use ProductAPI\Api\Data\ProductInterface;

interface ProductSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Function getItems
     *
     * @return ProductInterface[]
     */
    public function getItems();

    /**
     * Function setItems
     *
     * @param ProductInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
