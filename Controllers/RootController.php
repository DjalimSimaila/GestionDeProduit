<?php

class RootController extends AController {

    public function process(){
        switch($this->urlFolder){
            case 'login': {
                $loginController = new LoginController($this->urlParams);
                $loginController->display();
                break;
            }
            case '':
            case 'index':
            case 'products' : {
                $productsController = new ProductsController($this->urlParams);
                $productsController->display();
                break;
            }
            case 'product' : {
                $productController = new ProductController($this->urlParams);
                $productController->display();
                break;
            }
            case 'carts' : {
                $cartsController = new CartsController($this->urlParams);
                $cartsController->display();
                break;
            }
            case 'cart' : {
                $cartController = new CartController($this->urlParams);
                $cartController->display();
                break;
            }
            case 'api': {
                $this->callController(new APIController());
                break;
            }
            default:{
                throw new HTTPSpecialCaseException(404);
            }

        }
    }
}
