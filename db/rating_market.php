<?php
    session_start();
    include('server.php');

    $error = array();

    if (isset($_GET['market_name'])) {
        $market_name = $_GET['market_name'];
    }

    $show_market = "SELECT * FROM market_list WHERE market_name = '$market_name'";
    $show_market_query = mysqli_query($conn, $show_market);
    $show_market_result = mysqli_fetch_assoc($show_market_query);

    $market_id = $show_market_result['market_id'];
    $market_point_total = $show_market_result['market_point'];

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $rate = $_GET['rating-point'];
        $market_point_total += $rate;
        
        $insert_rating = "INSERT INTO rating_market (market_id, market_name, rate, voter) VALUES ('$market_id', '$market_name', '$rate', '$username')";
        mysqli_query($conn, $insert_rating);

        $rating_system = "UPDATE market_list SET market_point = $market_point_total WHERE market_name = '$market_name'";
        mysqli_query($conn, $rating_system);

        header('location: ../market.php?market_name=' . $market_name);
    } else {
        header('location: ../market.php?market_name=' . $market_name);
        array_push($error, "กรุณาเข้าสู่ระบบเพื่อให้คะแนน");
        $_SESSION['error'] = "กรุณาเข้าสู่ระบบเพื่อให้คะแนน";
    }


?>