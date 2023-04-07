<?php
foreach ($A_view["cart"] as $cart) {
    echo "<a href=\"/cart/".$cart["id"]."\">".$cart["name"]."</a>
    <p> Total price: ".$cart["total_price"]."€</p></br>";
}
