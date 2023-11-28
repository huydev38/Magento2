<?php
namespace MyModules\ProductAPI\Model;

use MyModules\ProductAPI\Api\ProductInterface;

header("Content-type: application/json; charset=utf-8");
 
class Product implements ProductInterface
{
    protected $_productRepository;

    public function __construct(\Magento\Catalog\Model\ProductRepository $productRepository) {
        $this->_productRepository = $productRepository;

    }

    public function attribute($id) {

        $product = $this->_productRepository->getById($id);
        $attributes = $product->getAttributes();        

        $response = array();

        foreach($attributes as $a)
        {
            // echo $a->getStoreLabel().": \n";
            // echo $a->getFrontendLabel().": \n";    
            // echo $a->getFrontend()->getLabel().": \n";

            $name = json_encode($a->getFrontend()->getLabel(), JSON_UNESCAPED_UNICODE);
            //echo $name.": ";
            $value = json_encode($a->getFrontend()->getValue($product), JSON_UNESCAPED_UNICODE );
            //echo $value."\n";

            // Nếu cả hai thuộc tính name và value đều không null thì mới thêm vào object
            // if($a->getFrontend()->getLabel() != null && $a->getFrontend()->getValue($product) != null) {
            //     array_push($response, [$a->getFrontend()->getLabel() => $a->getFrontend()->getValue($product)]);
            // }

            array_push($response, [$a->getFrontend()->getLabel() => $a->getFrontend()->getValue($product)]);


        }

        echo json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}