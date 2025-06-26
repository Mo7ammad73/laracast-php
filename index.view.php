
<?php
    $products = [
        ['name' => 'Laptop', 'price' => 1500, 'category' => 'Electronics'],
        ['name' => 'Shoes', 'price' => 100, 'category' => 'Fashion'],
        ['name' => 'Phone', 'price' => 800, 'category' => 'Electronics'],
        ['name' => 'T-Shirt', 'price' => 25, 'category' => 'Fashion'],
        ['name' => 'Book', 'price' => 20, 'category' => 'Books']
    ];
    $product = array_filter($products, function ($p) { return $p["category"] == "Electronics"; });
    $product = array_values($product);
    $product = array_map(function($p){ return ["name" => $p["name"] , "price"=> $p["price"] * 1.1];} , $product);

?>
