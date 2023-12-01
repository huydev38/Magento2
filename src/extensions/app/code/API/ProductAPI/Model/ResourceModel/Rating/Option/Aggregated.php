<?php

namespace API\ProductAPI\Model\ResourceModel\Rating\Option;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Aggregated extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('rating_option_vote_aggregated', 'primary_id');
    }
}
