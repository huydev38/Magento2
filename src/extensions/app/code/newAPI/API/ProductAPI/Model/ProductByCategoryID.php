<?php
namespace API\ProductAPI\Model;
use API\ProductAPI\Api\ProductByCategoryIDInterface;
use Magento\Framework\View\Element\Template;


class ProductByCategoryID extends Template implements ProductByCategoryIDInterface
{
    protected $_productCollectionFactory;
  
    public function __construct(       
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    )
    {    
        $this->_productCollectionFactory = $productCollectionFactory;
    }
    
    
    public function getProductCollectionByCategories($ids)
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => $ids]);
        return $collection;
    }
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function getProductByCategoryID($cid) {
        $productCollection = $this->getProductCollectionByCategories($cid);
        $data = [];
        foreach ($productCollection as $k => $product) {
        	$data[$k + 1] = [
                        'ID' => $product['entity_id'],
                        'SKU' => $product['sku'],
                        'NAME' => $product['name'],
                        'PRICE' => $product['price'],
                        'URL KEY' => $product['url_key'],
                        'META_TITLE' => $product['meta_title'],
                        'META_DESCRIPTION' => $product['meta_description'],
                        'SHORT_DESCRIPTION' => $product['short_description'],
                        'DESCRIPTION' => $product['description'],
                        'IMAGE' => $product['image'],
                        'STATUS_ID' => $product['status'],
                ];
              
          }
          return $data;
        }
}
