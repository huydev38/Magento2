<?php


namespace VTCGateway\VTCPay\Controller\Order;

use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Store\Model\ScopeInterface;

class checkout extends \Magento\Framework\App\Action\Action
{
	protected $resultPageFactory;
	protected $jsonFac;
	protected $order;
	protected $scopeConfig;
	protected $storeManager;
	protected $checkoutSession;


	public function __construct(
		Context $context,
		PageFactory $resultPageFactory,
		\Magento\Framework\Controller\Result\Json $json,
		\Magento\Sales\Model\Order $order,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager,
		\Magento\Checkout\Model\Session $checkoutSession
	)
	{
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
		$this->jsonFac = $json;
		$this->order = $order;
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
		$this->checkoutSession = $checkoutSession;
	}

	public function execute()
	{
		 $id = $this->getRequest()->getParam('order_id',0);
		 $order = $this->order->load(intval($id));
		 $url = "http://alpha1.vtcpay.vn/portalgateway/checkout.html";	 
		 
		 $test_mode = $this->scopeConfig->getValue('payment/vtcpay/test_mode');
		 if(!$test_mode){
		 	$url = "https://vtcpay.vn/bank-gateway/checkout.html";	
		 }
		 $language = 'vi';
		 $language_mode = $this->scopeConfig->getValue('payment/vtcpay/select_language');		
		 if($language_mode=='0'){$language = 'en';}
		
		 if($order->getId())
		 {		
			 $returnUrl = $this->storeManager->getStore()->getBaseUrl();
			 $returnUrl = rtrim($returnUrl,"/");
			 $returnUrl .= "/vtcgatewayvtcpay/order/notification";
			 
			 $reference_number = $order->getIncrementId();	
			 $amount = round($order->getTotalDue(), 2);
			 $currency = $this->storeManager->getStore()->getCurrentCurrencyCode();			 
			 $payment_type = "";
			 $receiver_account = $this->scopeConfig->getValue('payment/vtcpay/receiver_account');
			 $website_id= $this->scopeConfig->getValue('payment/vtcpay/website_id');
			 $secret_key= $this->scopeConfig->getValue('payment/vtcpay/secret_key');
			
			 $plaintext = $amount ."|". $currency ."|". $language ."|". $payment_type ."|". $receiver_account ."|". $reference_number ."|". $returnUrl ."|". $website_id ."|".$secret_key;
		
			 $sign = strtoupper(hash('sha256', $plaintext));
			
			 $url_return = urlencode($returnUrl);
			 $data = "?reference_number=" . $reference_number . "&website_id=" . $website_id . "&amount=" . $amount . "&receiver_account=" . $receiver_account . "&currency=" . $currency. "&language=" .  $language . "&url_return=" . $url_return. "&payment_type=" . $payment_type . "&signature=" .$sign;			
			 $url =  $url . $data;		

		  }

		$this->jsonFac->setData($url);
		return $this->jsonFac;
	}
}