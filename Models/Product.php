<?php

class Product {
    public int $I_id = 0;
    public string|null $S_name = null;
    public int $I_quantity = 0;
    public float $F_price = 0;

    public static function createEmpty()
    {
        return new Product();
    }

    public static function createFull(string $S_name, int $I_quantity, float $F_price): Product
    {
        $product = new Product();
        $product->S_name = $S_name;
        $product->I_quantity = $I_quantity;
        $product->F_price = $F_price;
        return $product;
    }

    public function insert()
    {
        $O_data = array(
            "name" => $this->S_name,
            "price" => $this->F_price,
            "quantity" => $this->I_quantity,
        );
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/product",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($O_data)
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        $this->I_id = json_decode($response)->id;
        curl_close($curlConnection);
    }

    public static function getById(int $I_id): Product
    {
        return new Product();
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/product/".$I_id,
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
        $response = json_decode($response);
        $product = new Product();
        $product->I_id = $I_id;
        $product->S_name = $response->name;
        $product->I_quantity = $response->quantity;
        $product->F_price = $response->price;
        return $product;
    }

    public function update()
    {
        $O_data = array(
            "name" => $this->S_name,
            "price" => $this->F_price,
            "quantity" => $this->I_quantity,
        );
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/product/".$this->I_id,
            CURLOPT_PUT => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($O_data),
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }

    public function delete()
    {
        $curlConnection  = curl_init();
        $params = array(
            CURLOPT_URL =>  "http://localhost:8080/product/".$this->I_id,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }
}

