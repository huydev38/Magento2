<?php
namespace MyModules\Weather\Block;
class Index extends \Magento\Framework\View\Element\Template
{
    public function __construct(\Magento\Framework\View\Element\Template\Context $context)
	{
		parent::__construct($context);
    }

	public function getWeatherData(){

        //Lấy weather icon http://openweathermap.org/img/w/{id icon}.png

        $url = "http://api.openweathermap.org/data/2.5/group?id=1581129,1580578,1586182,1581297,1565033,1572151,1581188,1905678&lang=vi&appid=a769a9cb72af59f2a746e7decf4f2eb4";

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $content = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $xml = json_decode($content);

        return $xml;
    }
}