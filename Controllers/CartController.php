<?php
class CartController {
    private array $A_CartInfo;

    public function __construct(array $urlParams) {
        $idCart = array_shift($urlParams);
        if($idCart == null) {
            throw new HTTPSpecialCaseException(404, "No cart id provided");
        }
        $cart = Cart::getById($idCart);

        if ($cart == null) {
            throw new HTTPSpecialCaseException(404, "Cart not found");
        }

        $productAdded = null;
        $productAdded = array_shift($urlParams);
        if($productAdded != null)
            $cart->addProduct(Product::getById($productAdded), 1);

        $this->A_CartInfo["id"] = $cart->I_id;
        $this->A_CartInfo["name"] = $cart->S_name;
        $this->A_CartInfo["user_id"] = $cart->I_user_id;
        $this->A_CartInfo["products"] = [];
        $this->A_CartInfo["total_price"] = 0;
        foreach ($cart->A_products as $product) {
            $this->A_CartInfo["products"][] = [
                "id" => $product["product"]->I_id,
                "name" => $product["product"]->S_name,
                "quantity" => $product["quantity"],
                "price" => $product["product"]->F_price
            ];
            $this->A_CartInfo["total_price"] += $product["quantity"] * $product["product"]->F_price;
        }
    }

    public function display() {
        View::show("cart", $this->A_CartInfo);
    }
}
