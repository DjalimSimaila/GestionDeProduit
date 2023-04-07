<h1>Cart: <?= $A_view["name"] ?></h1>
<?php foreach ($A_view["products"] as $product) {
    echo "<p>Product: <a href=\"/product/".$product["id"]."\">".$product["name"]."</a></p>
    <p>Quantity taken: ".$product["quantity"]."</p>
    <p>Price: ".$product["price"]."€</p></br>";
}
?>
<p> Total price: <?= $A_view["total_price"] ?>€</p>
