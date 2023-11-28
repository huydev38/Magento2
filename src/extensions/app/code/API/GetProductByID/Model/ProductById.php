<?php
namespace API\GetProductByID\Model;
use API\GetProductByID\Api\ProductByIdInterface;
use Magento\Framework\View\Element\Template;


class ProductById extends Template implements ProductByIdInterface
{
    protected $_productCollectionFactory;

    public function __construct(

        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        array $data = []
    )

    {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getProductCollection()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        //$collection->setPageSize(3); // fetching only 3 products
        return $collection;
    }
    /**
     * Returns greeting message to user
     *
     * @api
     * @param string $name Users name.
     * @return string Greeting message with users name.
     */
    public function getProductById($id) {
        $productCollection = $this->getProductCollection();
        $data = [];
        foreach ($productCollection as $product) {
            if($product['entity_id'] == $id){
                $data[$product->getAttributeCode()] = [
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
          }
          return $data;
        }
}
