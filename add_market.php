<?php 

    include('db/server.php');

    $error = array();

    if (isset($_POST['add-market'])) {

        $market_name = mysqli_real_escape_string($conn, $_POST['market_name']);
        $market_content = mysqli_real_escape_string($conn, $_POST['market_content']);
        $market_contact = mysqli_real_escape_string($conn, $_POST['market_contact']);
        $owner = mysqli_real_escape_string($conn, $_POST['owner']);

        $dir = "img/upload/market_list/";
        $fileImage = $dir . basename($_FILES['market_img']['name']);

        if (move_uploaded_file($_FILES['market_img']['tmp_name'], $fileImage)) {

            $insert_market = "INSERT INTO market_list (market_img, market_name, market_content,  market_contact, owner) VALUES ('$fileImage' ,'$market_name', '$market_content', ' $market_contact', '$owner')";
            mysqli_query($conn, $insert_market);

            $create_market_data = "CREATE TABLE $market_name (
                item_id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
                item_img text NOT NULL,
                item_name text NOT NULL,
                item_content mediumtext NOT NULL,
                item_price int NOT NULL,
                item_category text NOT NULL,
                item_type text NOT NULL
                )ENGINE=INNODB DEFAULT CHARSET=utf8;";
        
            mysqli_query($conn, $create_market_data);

            header('location: index.php');
        } else {
            array_push($error, "อัพโหลดข้อมูลไม่สำเร็จ");
            $_SESSION['error'] = "อัพโหลดข้อมูลไม่สำเร็จ";
            header('location: index.php');
        }

    }
?>