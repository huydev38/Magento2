<?php

namespace VTCGateway\VTCPay\Model;

class VTCPay extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_VTCPAY_CODE = 'vtcpay';

    protected $_code = self::PAYMENT_METHOD_VTCPAY_CODE;

    protected $_isOffline = true;


}
