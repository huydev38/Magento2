<?php

namespace API\ProductAPI\Model\ResourceModel\Rating\Option\Aggregated;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use API\ProductAPI\Model\Rating\Option\Aggregated;
use API\ProductAPI\Model\ResourceModel\Rating\Option\Aggregated as ResourceModelAggregated;

class Collection extends AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'primary_id';

    /** @var string */
    protected $_eventPrefix = 'gracious_rating_aggregated_collection';

    /** @var string */
    protected $_eventObject = 'rating_aggregated_collection';

    protected function _construct()
    {
        $this->_init(
            Aggregated::class,
            ResourceModelAggregated::class
        );
    }
}
