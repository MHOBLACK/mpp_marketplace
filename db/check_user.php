<?php
    session_start();
    include('server.php');

    if (isset($_SESSION['username'])) {

        $username = $_SESSION['username'];
        $market_name = $_GET['market_name'];

        $show_market = "SELECT * FROM market_list WHERE market_name = '$market_name'";
        $show_market_query = mysqli_query($conn, $show_market);
        $show_market_result = mysqli_fetch_assoc($show_market_query);

        $owner = $show_market_result['owner'];

        if ($username === $owner) {

            // ไม่ต้องทำอะไร
            
        } else {
            header('location: index.php');
        }


    } else {
        header('location: index.php');
    }
?>