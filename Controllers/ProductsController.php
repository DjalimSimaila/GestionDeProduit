<?php
class ProductsController {
    private array $A_productsInfo;

    public function __construct(array $urlParams) {
        $this->A_productsInfo["products"] = [];
        foreach (Product::getAll() as $product) {
            $this->A_productsInfo["products"][] = [
                "id" => $product->I_id,
                "name" => $product->S_name,
                "price" => $product->F_price
            ];
        }
    }

    public function display() {
        View::show("products", $this->A_productsInfo);
    }

}
