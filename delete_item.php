<?php
    include('db/server.php');
    include('db/check_user.php');

    $item_id = $_GET['item_id'];
    $market_name = $_GET['market_name'];

    $delete_item_id = "DELETE FROM $market_name WHERE item_id = $item_id";
    mysqli_query($conn, $delete_item_id);

    header('location: market.php?market_name=' . $market_name);

?>