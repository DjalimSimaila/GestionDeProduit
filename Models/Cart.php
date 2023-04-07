<?php

class Cart
{
    public int $I_id = 0;
    public int $I_user_id = 0;
    public string $S_name = "";
    public WeakMap $M_products;
    public array $A_products = array();
    public float $F_price;

    public static function createEmpty(): Cart
    {
        return new Cart();
    }

    public static function createFull(string $S_name, int $I_user_id): Cart
    {
        $O_cart = new Cart();
        $O_cart->S_name = $S_name;
        $O_cart->I_user_id = $I_user_id;
        return $O_cart;
    }

    public static function getById(int $I_id): Cart
    {
        $tmpCart = self::createFull("test", 1);
        $tmpCart->addProduct(Product::getById(1), 1);
        return $tmpCart;
        /*  $curlConnection  = curl_init();
        $params = array(
        CURLOPT_URL =>  "http://localhost:8080/carts/".$I_id,
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
        return $O_cart; */
    }

    public static function getAll(): array
    {
        return [
            self::createFull("test", 1),
            self::createFull("test2", 2),
            self::createFull("test3", 3)
        ];
    }

    public function insert()
    {
        $O_data = array(
            "name" => $this->S_name,
            "user_id" => $this->I_user_id,
        );
        $curlConnection = curl_init();
        $params = array(
            CURLOPT_URL => "http://localhost:8080/carts",
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($O_data)
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);

        foreach ($this->M_products as $product => $quantity) {
            $curlConnection = curl_init();
            $params = array(
                CURLOPT_URL => "http://localhost:8080/carts/" . $response . "/product/" . $product->I_id,
                CURLOPT_POST => 1,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => "quantity=" . $quantity,
            );
            curl_setopt_array($curlConnection, $params);
            $response = curl_exec($curlConnection);
            curl_close($curlConnection);
        }
    }

    public function update()
    {
        $A_products_update = array();

        foreach ($this->A_products as $product) {
            $A_products_update[] = array(
                "product_id" => $product["product"]->I_id,
                "quantity" => $product["quantity"]
            );
        }

        $O_data = array(
            "name" => $this->S_name,
            "user_id" => $this->I_user_id,
            "products" => $A_products_update
        );

        $curlConnection = curl_init();
        $params = array(
            CURLOPT_URL => "http://localhost:8080/carts/" . $this->I_id,
            CURLOPT_PUT => 1,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($O_data)
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }

    public function addProduct(Product $O_product, int $I_quantity)
    {
        $this->A_products = array(
            "product" => $O_product,
            "quantity" => $I_quantity
        );

        /*         $O_data = array(
        "product_id" => $O_product->I_id,
        "quantity" => $I_quantity
        );
        $curlConnection  = curl_init();
        $params = array(
        CURLOPT_URL =>  "http://localhost:8080/cart/".$this->I_id."/product/".$O_product->I_id,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => json_encode($O_data),
        ); */
    }

    public function deleteProduct(Product $O_product)
    {
        foreach ($this->A_products as $key => $product) {
            if ($product["product"]->I_id == $O_product->I_id) {
                unset($this->A_products[$key]);
            }
        }
        $curlConnection = curl_init();
        $params = array(
            CURLOPT_URL => "http://localhost:8080/cart/" . $this->I_id . "/product/" . $O_product->I_id,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }

    public function delete()
    {
        $curlConnection = curl_init();
        $params = array(
            CURLOPT_URL => "http://localhost:8080/cart/" . $this->I_id,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($curlConnection, $params);
        $response = curl_exec($curlConnection);
        curl_close($curlConnection);
    }

    public function getPrice(): float{
        $this->F_price = 0;
        foreach ($this->A_products as $product){
            $this->F_price += $product["product"]->F_price * $product["quantity"];
        }
        return $this->F_price;
    }
}
