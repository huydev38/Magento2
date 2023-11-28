<?php

namespace VTCGateway\VTCPay\Controller\Order;

use Magento\Framework\App\Action\Context;

class notification extends \Magento\Framework\App\Action\Action
{

	protected $order;
	protected $checkoutSession;
	protected $scopeConfig;
	protected $storeManager;
	
	public function __construct( Context $context,
		\Magento\Sales\Model\Order $order,
		\Magento\Checkout\Model\Session $checkoutSession,
		\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
		\Magento\Store\Model\StoreManagerInterface $storeManager
		)
	{
		parent::__construct( $context );
		$this->order = $order;
		$this->checkoutSession = $checkoutSession;
		$this->scopeConfig = $scopeConfig;
		$this->storeManager = $storeManager;
	}

    public function execute()
    {
		
		$secret_key = $this->scopeConfig->getValue('payment/vtcpay/secret_key');
		$status_success = $this->scopeConfig->getValue('payment/vtcpay/select_p_success');
		$status_failed = $this->scopeConfig->getValue('payment/vtcpay/select_p_failed');
		$status_cancel = $this->scopeConfig->getValue('payment/vtcpay/select_p_cancel');
		$status_review = $this->scopeConfig->getValue('payment/vtcpay/select_p_review');
		$status_fraud = $this->scopeConfig->getValue('payment/vtcpay/select_p_fraud');
		
		if (isset($_GET['status']) && !empty($_GET['status'])) { //get
			
			//data receive get
			$amount = $_GET["amount"];
			$message = $_GET["message"];
			$payment_type = $_GET["payment_type"];
			$reference_number = $_GET["reference_number"];
			$status = $_GET["status"];
			$trans_ref_no = $_GET["trans_ref_no"];
			$website_id = $_GET["website_id"];
			$signature = $_GET["signature"];
			
			$plaintext = $amount . "|" . $message . "|" . $payment_type . "|" . $reference_number . "|" . $status . "|" . $trans_ref_no. "|" . $website_id. "|" . $secret_key;
			$mysign = strtoupper(hash('sha256', $plaintext));
			$data = $plaintext;
			
			$order = $this->order->loadByIncrementId($reference_number);
			if($mysign != $signature)
			{
				if($order->getId())
			    {
				    if($this->checkoutSession->getLastOrderId() == $order->getId())
				    {
					    $order->setTotalPaid(floatval($amount));
					    $order->setStatus($status_fraud);
					    $order->save();
				    }
			    }
				return $this->resultRedirectFactory->create()->setPath('checkout/onepage/failure');
			}
			
			switch ($status) {
			case 1:
				if($order->getId())
			    {
				    if($this->checkoutSession->getLastOrderId() == $order->getId())
				    {
					    $order->setTotalPaid(floatval($amount));
					    $order->setStatus($status_success);
					    $order->save();
				    }
			    }
				$this->messageManager->addSuccess('Bạn đã thanh toán thành công đơn hàng có trị giá: ' . $amount . $this->storeManager->getStore()->getCurrentCurrencyCode());
				return $this->resultRedirectFactory->create()->setPath('checkout/onepage/success');
			
			case 7:
			case 0:
				if($order->getId())
			    {
				    if($this->checkoutSession->getLastOrderId() == $order->getId())
				    {
					    $order->setTotalPaid(floatval($amount));
					    $order->setStatus($status_review); 
					    $order->save();
				    }
			    }
				$this->messageManager->addSuccess('Đơn hàng của bại bị tạm giữ. Vui lòng liên hệ CSKH hoặc gọi điện đến số máy 19001530 để được giải quyết');
				return $this->resultRedirectFactory->create()->setPath('checkout/onepage/failure');
				
			case -9:
				if($order->getId())
			    {
				    if($this->checkoutSession->getLastOrderId() == $order->getId())
				    {
					    $order->setTotalPaid(floatval($amount));
					    $order->setStatus($status_cancel); 
					    $order->save();
				    }
			    }
				$this->messageManager->addSuccess('Bạn đã hủy thành công đơn hàng có trị giá: ' . $amount . $this->storeManager->getStore()->getCurrentCurrencyCode());
				return $this->resultRedirectFactory->create()->setPath('checkout/cart');
			
			default:
				if($order->getId())
			    {
				    if($this->checkoutSession->getLastOrderId() == $order->getId())
				    {
					    $order->setTotalPaid(floatval($amount));
					    $order->setStatus($status_failed);
					    $order->save();
				    }
			    }
				$this->messageManager->addSuccess('Thanh toán đơn hàng thất bại');
				return $this->resultRedirectFactory->create()->setPath('checkout/onepage/failure');
			}			
	
		}
		
		
		if(isset($_POST["data"]) && !empty($_POST["data"])){ //post
			
			//data receive post
			$data = $_POST["data"];
			$sign = $_POST["signature"];
			$plaintext = $data . "|" . $secret_key;
			$mysign = strtoupper(hash('sha256', $plaintext));
			$arrData = explode("|",$data);
			$status = $arrData[4];
			$amount = $arrData[0];
			$reference_number = $arrData[3];
			
			$order = $this->order->loadByIncrementId($reference_number);

			if($mysign != $sign)
			{
				if(!empty($order->getId()))
			    {		    
					$order->setTotalPaid(floatval($amount));
					$order->setStatus($status_fraud);
					$order->save();
			    }
				echo  "Fail to validate data - signature invalid" ;
				return;
			}
			
			switch ($status) {
			case 1:
				if(!empty($order->getId()))
			    {
					$order->setTotalPaid(floatval($amount));
					$order->setStatus($status_success);
					$order->save();
			    }
				echo "Bạn đã thanh toán thành công đơn hàng có trị giá: " . $amount . $this->storeManager->getStore()->getCurrentCurrencyCode();
				return;
			
			case 7:
			case 0:
				if(!empty($order->getId()))
			    {
					$order->setTotalPaid(floatval($amount));
					$order->setStatus($status_review); 
					$order->save();
			    }
				 echo "Đơn hàng của bại bị tạm giữ. Vui lòng liên lệ CSKH để được giải quyết";
				return;
				
			case -9:
				if(!empty($order->getId()))
			    {				    
					$order->setTotalPaid(floatval($amount));
					$order->setStatus($status_cancel); 
					$order->save();			
			    }
				echo "Bạn đã hủy thành công đơn hàng có trị giá: " . $amount . $this->storeManager->getStore()->getCurrentCurrencyCode();
				return;
			
			default:
				if(!empty($order->getId()))
			    {
					$order->setTotalPaid(floatval($amount));
					$order->setStatus($status_failed);
					$order->save();
			    }
				echo "Thanh toán đơn hàng thất bại";
				return;
			}			
		}
    }	
}
