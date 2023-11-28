<?php
namespace MyModules\News\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{
		parent::__construct($context);
    }
    
	public function getNews()
	{
        $url = "https://www.techz.vn/rss/tablet-laptop-may-tinh.rss";

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