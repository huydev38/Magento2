<?php

  namespace API\ProductAPI\Api;

  /**
   * interface get product data API XML by product id
   */
  interface ProductByCategoryIDInterface
  {
    /**
     * @api
     * @param string $id Product id.
     * @return string product data
     */
    public function getProductByCategoryID($cid);
  }


 ?>
