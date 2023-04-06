<h1>Cart: <?= $A_view["name"] ?></h1>
<?php foreach ($A_view["products"] as $key => $value) {
    echo "<p>Product: ".$value["name"]."</p>
    <p>Quantity taken: ".$value["quantity"]."</p>
    <>Price: ".$value["price"]."</p></br>";
}
?>
<p> Total price: <?= $A_view["total_price"] ?></p>
