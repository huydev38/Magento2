define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'vtcpay',
                component: 'VTCGateway_VTCPay/js/view/payment/method-renderer/vtcpay-method'
            }
        );
        return Component.extend({});
    }
);
