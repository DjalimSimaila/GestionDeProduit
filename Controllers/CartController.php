<?php
class CartController {
    private array $A_CartInfo;

    public function __construct($urlParams) {
        $idCart = array_shift($urlParams);
        if($idCart == null) {
            throw new HTTPSpecialCaseException(404, "No cart id provided");
        }
        $cart = Cart::getById($idCart);

        if ($cart == null) {
            throw new HTTPSpecialCaseException(404, "Cart not found");
        }

        $this->A_CartInfo["id"] = $cart->I_id;
        $this->A_CartInfo["name"] = $cart->S_name;
        $this->A_CartInfo["user_id"] = $cart->I_user_id;
        $this->A_CartInfo["products"] = [];
        $this->A_CartInfo["total_price"] = 0;
        foreach ($cart->M_products as $key => $value) {
            $this->A_CartInfo["products"][] = [
                "id" => $key->I_id,
                "name" => $key->S_name,
                "quantity" => $value,
                "price" => $key->F_price
            ];
            $this->A_CartInfo["total_price"] += $key->F_price * $value;
        }
    }

    public function display() {
        View::show("cart", $this->A_CartInfo);
    }
}
