<?php

class CartsController {
    private array $A_carts = array();

    public function __construct($urlParams){
        $carts = Cart::getAll();

        foreach ($carts as $cart){
            $this->A_carts["cart"][] = [
                "id" => $cart->I_id,
                "name" => $cart->S_name,
                "user_id" => $cart->I_user_id,
                "total_price" => $cart->getPrice()
            ];
        }
    }

    public function display(){
        View::show("carts", $this->A_carts);
    }
}
