<?php
namespace MyModules\ExchangeRate\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{
		parent::__construct($context);
	}
    
    public function getExchangeRatesVCB(){
        $url = "https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx";

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $content = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $xml = simplexml_load_string($content);

        return $xml;
    }
}

// Truy cập địa chỉ: http://127.0.0.1/magento/exchangerate/index/index