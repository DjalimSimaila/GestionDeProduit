<?php
foreach ($A_view["products"] as $product) {
    echo '<a href="/product/'.$product["id"].'"><p>'.$product["name"].'</p></a>
    <p>'.$product["price"].'€</p></br>';
}
