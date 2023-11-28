<?php 
namespace MyModules\CronJob\Cron; 
use Magento\Backend\App\Action\Context; 
use Magento\Backend\App\Action; 
use Magento\Framework\App\Cache\Manager as CacheManager; 
use Magento\Framework\App\Cache\TypeListInterface as CacheTypeListInterface; 
class Cron 
{ 
    public function __construct(\Magento\Framework\Model\Context $context,\Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,\Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool) 
    { 
        $this->_cacheTypeList = $cacheTypeList; 
        $this->_cacheFrontendPool = $cacheFrontendPool; 
    } 

    public function myCronFunction() 
    { 
        $cache_types = array('full_page'); 
        foreach ($cache_types as $type) { 
            $this->_cacheTypeList->cleanType($type); 
        } 
        foreach ($this->_cacheFrontendPool as $cache_clean_flush) { 
            $cache_clean_flush->getBackend()->clean(); 
        }
    } 
} 