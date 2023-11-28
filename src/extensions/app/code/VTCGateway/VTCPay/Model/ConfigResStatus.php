<?php

namespace VTCGateway\VTCPay\Model;

class ConfigResStatus extends \Magento\Payment\Model\Method\AbstractMethod
{
    public function toOptionArray()
	 {
		return [
			['value' => 'pending_payment', 'label' => __('Pending Payment')],
			['value' => 'processing', 'label' => __('Processing')],
			['value' => 'complete', 'label' => __('Complete')],
			['value' => 'closed', 'label' => __('Closed')],
			['value' => 'canceled', 'label' => __('Canceled')],
			['value' => 'holded', 'label' => __('On Hold')],
			['value' => 'payment_review', 'label' => __('Payment Review')],
			['value' => 'fraud', 'label' => __('Suspected Fraud')]
		];
	}


}
