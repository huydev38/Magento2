<?php

namespace Meetanshi\FacebookChat\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Meetanshi\FacebookChat\Helper\Data;

/**
 * Class Messenger
 * @package Meetanshi\FacebookChat\Block
 */
class Messenger extends Template
{
    /**
     * @var Data
     */
    protected $helperData;

    /**
     * Messenger constructor.
     * @param Context $context
     * @param Data $helperData
     */
    public function __construct(
        Context $context,
        Data $helperData
    ) {
        parent::__construct($context);
        $this->helperData = $helperData;
    }
}
