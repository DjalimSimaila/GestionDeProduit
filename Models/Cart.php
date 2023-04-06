<?php

class Cart {
    public int $I_id = 0;
    public int $I_user_id = 0;
    public string $S_name = "";
    public WeakMap $M_products;

    public static function createEmpty(): Cart {
        return new Cart();
    }

    public static function createFull(string $S_name, int $I_user_id): Cart {
        return new Cart();
    }
    public function update(){
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/cart/".$this->I_id,
            CURLOPT_PUT => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "name=".$this->S_name."&user_id=".$this->I_user_id,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }
    public function insert(){
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/cart",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => "name=".$this->S_name."&user_id=".$this->I_user_id,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        foreach ($this->M_products as $product => $quantity){
            $curlConnection  = curl_init();
            $params = array(
                CURLOPT_URL =>  "http://localhost:8080/cart/".$response."/product/".$product->I_id,
                CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => "quantity=".$quantity,
            );
            curl_setopt_array($curlConnection, $params);
            $response = curl_exec($curlConnection);
            curl_close($curlConnection);
        }
    }
    public static function getById(int $I_id): Cart {
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/cart/".$I_id,
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
        $response = json_decode($response);
        $O_cart = new Cart();
        $O_cart->S_name = $response->name;
        $O_cart->I_user_id = $response->user_id;
        foreach ($response->products as $product){
            $O_product = Product::getById($product->id);
            $O_cart->addProduct($O_product,$product->quantity);
        }
        return $O_cart;
    }
    public function addProduct(Product $O_product,int $I_quantity) {
        $this->M_products[$O_product] = $I_quantity;
    }
}
