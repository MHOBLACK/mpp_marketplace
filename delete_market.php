<?php 
    include('db/server.php');
    include('db/check_user.php');

    $market_id = $_GET['delete_market_id'];

    $check_market = "SELECT * FROM market_list WHERE market_id = $market_id";
    $check_market_query = mysqli_query($conn, $check_market);
    $check_market_result = mysqli_fetch_assoc($check_market_query);

    $market_name = $check_market_result['market_name'];

    $delete_market_data = "DROP TABLE $market_name";
    mysqli_query($conn, $delete_market_data);

    $delete_market_list = "DELETE FROM market_list WHERE market_id = $market_id";
    mysqli_query($conn, $delete_market_list);

    header('location: index.php');

?>