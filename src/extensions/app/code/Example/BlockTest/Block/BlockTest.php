<?php

namespace Example\BlockTest\Block;

use Magento\Framework\View\Element\Template;

class BlockTest extends Template
{
    public function getText() {
        return "Hello World";
    }
}
