<?php

namespace Modules\Weather\Block;

use Magento\Framework\View\Element\Template;

class WeatherBlock extends Template
{
  public function getText() {
        return "Hello World";
  }

  public function __construct(\Magento\Framework\View\Element\Template\Context $context) {
  		parent::__construct($context);
  }
}
