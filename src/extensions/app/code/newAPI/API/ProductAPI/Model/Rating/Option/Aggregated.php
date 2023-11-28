<?php

namespace API\ProductAPI\Model\Rating\Option;

use Magento\Framework\Model\AbstractModel;
use API\ProductAPI\Model\ResourceModel\Rating\Option\Aggregated as AggregatedResourceModel;

class Aggregated extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(AggregatedResourceModel::class);
    }
}
