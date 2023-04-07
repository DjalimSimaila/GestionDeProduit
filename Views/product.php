<h1><?= $A_view["name"] ?></h1>
<p>Quantity: <?= $A_view["quantity"] ?></p>
<p>Price: <?= $A_view["price"] ?></p>
<?php
foreach ($A_view["carts"] as $cart) {
    echo "<a href=\"/cart/".$cart["id"]."\">Add to ".$cart["name"]."</a></br>";
}
