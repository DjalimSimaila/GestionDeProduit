<?php
class ProductController {

	private array $A_ProductInfo;

    public function __construct(array $urlParams) {
        $idProduct = array_shift($urlParams);
        if($idProduct == null) {
            throw new HTTPSpecialCaseException(404, "No product id provided");
        }
        $product = Product::getById($idProduct);
        $carts = Cart::getAll();

        if ($product == null) {
            throw new HTTPSpecialCaseException(404, "Product not found");
        }

        $this->A_ProductInfo["id"] = $product->I_id;
        $this->A_ProductInfo["name"] = $product->S_name;
        $this->A_ProductInfo["quantity"] = $product->I_quantity;
        $this->A_ProductInfo["price"] = $product->F_price;
        foreach ($carts as $cart) {
            $this->A_ProductInfo["carts"][] = [
                "id" => $cart->I_id,
                "name" => $cart->S_name
            ];
        }
    }

    public function display() {
        View::show("product", $this->A_ProductInfo);
    }
}
