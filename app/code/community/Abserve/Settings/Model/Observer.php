<?php

class Abserve_Settings_Model_Observer
{
    public function updatePrice($observer)
    {
        $event = $observer->getEvent();
        $product = $event->getProduct();
        $quote_item = $event->getQuoteItem();


        $ip = $_SERVER['REMOTE_ADDR'];
        $url = 'http://freegeoip.net/json/'.$ip;
        $rCURL = curl_init();
        curl_setopt($rCURL, CURLOPT_URL, $url);
        curl_setopt($rCURL, CURLOPT_HEADER, 0);
        curl_setopt($rCURL, CURLOPT_RETURNTRANSFER, 1);
        $aData = curl_exec($rCURL);
        curl_close($rCURL);
        $result = json_decode ( $aData );        
        $country = $result->country_code;
        $namecountry = trim($result->country_name);
        $getmycountry = trim($country);
        $countrycode = strtolower($getmycountry);



        $quote = Mage::getSingleton('checkout/session')->getQuote();
        $cartItems = $quote->getAllVisibleItems();
        foreach ($cartItems as $item) {
            $productId = $item->getProductId();           
            $product = Mage::getModel('catalog/product')->load($productId);
            $data = $item->getData();
            $cats = $product->getCategoryIds();
            $result = $product_content = $data['product']->getData();
            $product_quantity = $result['cart_qty'];
            $actualPrice = $product->getPrice();
            $specialPrice = $product->getFinalPrice();
            $product_price = $product_quantity * $specialPrice;
            $storeId = Mage::app()->getStore()->getStoreId();
            /*$price_in = Mage::getResourceModel('catalog/product')->getAttributeRawValue($productId, 'price_in', $storeId);
            $new_price = $price_in * $product_quantity;  */
            

        }
        
        

        //if($price_in > 0 && $countrycode == 'in'){
        //$countrycode = 'us';
        if($countrycode == 'in'){
            /*$quote_item->setCustomPrice($new_price);
            $quote_item->setOriginalCustomPrice($new_price);
            $quote_item->getQuote()->save();
            $quote_item->getProduct()->setIsSuperMode(true);*/
        }else{
            $price_international = Mage::getResourceModel('catalog/product')->getAttributeRawValue($productId, 'international_price', $storeId);
            $special_price_international = Mage::getResourceModel('catalog/product')->getAttributeRawValue($productId, 'international_sprice', $storeId);
            if($special_price_international > 0){
                $new_price = $special_price_international * $product_quantity; 
                $quote_item->setCustomPrice($new_price);
                $quote_item->setOriginalCustomPrice($new_price);
                $quote_item->getQuote()->save();
                $quote_item->getProduct()->setIsSuperMode(true);  
            }else{
                if($price_international > 0){
                    $new_price = $price_international * $product_quantity;
                    $quote_item->setCustomPrice($new_price);
                    $quote_item->setOriginalCustomPrice($new_price);
                    $quote_item->getQuote()->save();
                    $quote_item->getProduct()->setIsSuperMode(true);
                }                        
            }
        }
        
    }
}
