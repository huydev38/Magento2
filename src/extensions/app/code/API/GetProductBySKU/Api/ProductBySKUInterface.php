<?php

  namespace API\GetProductBySKU\Api;

  /**
   * interface get product data API XML by product id
   */
  interface ProductBySKUInterface
  {
    /**
     * @api
     * @param string $id Product id.
     * @return string product data
     */
    public function getProductBySKU($sku);
  }


 ?>
