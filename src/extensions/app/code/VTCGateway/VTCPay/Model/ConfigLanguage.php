<?php

namespace VTCGateway\VTCPay\Model;

class ConfigLanguage extends \Magento\Payment\Model\Method\AbstractMethod
{
    public function toOptionArray()
	 {
		return [
			['value' => '1', 'label' => __('VietNam')],
			['value' => '0', 'label' => __('English')]
		];
	}


}
