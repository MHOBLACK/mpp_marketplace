<?php

    // เริ่ม Session
    session_start();

    // ใช้ตัวแปรร่วมกับไฟล์ server.php
    include('db/server.php');

    // ตรวจสอบเงื่อนไขว่ามีการเรียกใช้ Method 'Logout' หรือไม่
    if (isset($_GET['logout'])) {

        // ทำลาย Session
        session_destroy();

        // ยกเลิกค่า Session 'username'
        unset($_SESSION['username']);

        // ไปที่หน้า index.php
        header('location: index.php');

    }

    // ตรวจสอบเงื่อนไขว่ามีการเรียกใช้ Method 'market_name' หรือไม่
    if (isset($_GET['market_name'])) {

        // สร้างตัวแปร market_name เพื่อเก็บข้อมูลจาก Method 'market_name'
        $market_name = $_GET['market_name'];

    } else { // หากไม่มี

        // ไปที่หน้า index.php
        header('location: index.php');

    }

    // ตรวจสอบเงื่อนไขว่ามี Session 'username' หรือไม่
    if (isset($_SESSION['username'])) {

        // สร้างตัวแปร username สำหรับเก็บค่า Session 'username'
        $username = $_SESSION['username'];

    }

    // ตรวจสอบเงื่อนไขว่ามี Session 'username' หรือไม่
    if (isset($_SESSION['username'])) {

        // สร้างตัวแปร SQL ดึงข้อมูลภายในตารางที่มีชื่อว่า 'user' ที่มีข้อมูลในคอลัมน์ 'username' มีค่าเท่ากับ '$username'
        $check_user = "SELECT * FROM user WHERE username = '$username'";

        // สร้างตัวแปร Query แสดงผลข้อมูล
        // $conn คือตัวแปรจาก server.php ที่ใช้สำหรับการเชื่อมต่อฐานข้อมูล
        $check_user_query = mysqli_query($conn, $check_user);

        // สร้างตัวแปร Fetch แสดงข้อมูลจากแถวนั้นๆ ออกมาจากการ Query ของตัวแปร '$check_user_query'
        // โดยเป็นการแสดงข้อมูลนั้นๆ โดยกำหนดว่า จะแสดงข้อมูลจาก Column ไหน
        $check_user_result = mysqli_fetch_assoc($check_user_query);

    }

    // สร้างตัวแปร SQL เพื่อดึงข้อมูลจากตารางที่มีชื่อเดียวกับตัวแปร '$market_name'
    $item_list = "SELECT * FROM $market_name";

    // สร้างตัวแปร Query แสดงผลข้อมูล
    // $conn คือตัวแปรจาก server.php ที่ใช้สำหรับการเชื่อมต่อฐานข้อมูล
    $item_list_query = mysqli_query($conn, $item_list);

    // สร้างตัวแปร Fetch แสดงข้อมูลจากแถวทั้งหมด ออกมาจากการ Query ของตัวแปร '$item_list_query'
    // โดยเป็นการแสดงผลข้อมูลทั้งหมด โดยกำหนดว่า จะแสดงข้อมูลจาก Column ไหน
    $item_list_result = mysqli_fetch_all($item_list_query, MYSQLI_ASSOC);

    // สร้างตัวแปร SQL ดึงข้อมูลภายในตารางที่มีชื่อว่า 'market_list' ที่มีข้อมูลในคอลัมน์ 'market_name' มีค่าเท่ากับ '$market_name'
    $show_market = "SELECT * FROM market_list WHERE market_name = '$market_name'";

    // สร้างตัวแปร Query แสดงผลข้อมูล
    // $conn คือตัวแปรจาก server.php ที่ใช้สำหรับการเชื่อมต่อฐานข้อมูล
    $show_market_query = mysqli_query($conn, $show_market);

    // สร้างตัวแปร Fetch แสดงข้อมูลจากแถวนั้นๆ ออกมาจากการ Query ของตัวแปร '$show_market_query'
    // โดยเป็นการแสดงข้อมูลนั้นๆ โดยกำหนดว่า จะแสดงข้อมูลจาก Column ไหน
    $show_market_result = mysqli_fetch_assoc($show_market_query);

    // สร้างตัวแปร owner สำหรับเก็บข้อมูล 'owner' จากตัวแปร $show_market_result ในคอลัมน์ 'owner'
    $owner = $show_market_result['owner'];

    // ตรวจสอบว่ามีการกดปุ่ม search หรือไม่
    if (isset($_POST['search'])) {

        // สร้างตัวแปร search_input เพื่อเก็บข้อมูลจาก input 'search-input'
        $search_input = $_POST['search-input'];
        
        // สร้างตัวแปร SQL เพื่อดึงข้อมูลจากตารางที่มีชื่อเดียวกับตัวแปร '$market_name' ที่มีข้อมูลในคอลัมน์ item_name มีเหมือนกับ '$search_input'
        // LIKE เป็นคำสั่งที่ใช้สำหรับการค้นหาข้อมูลโดยใช้ Keyword ยกตัวอย่างเช่น "ข้าวสาร", "ข้าวผัด" หากเราใช้คำว่า "ผัด" ในการค้นหาก็จะแสดงผลเป็น "ข้าวผัด"
        $item_list = "SELECT * FROM $market_name WHERE item_name LIKE '%$search_input%'";

        // สร้างตัวแปร Query แสดงผลข้อมูล
        // $conn คือตัวแปรจาก server.php ที่ใช้สำหรับการเชื่อมต่อฐานข้อมูล
        $item_list_query = mysqli_query($conn, $item_list);

        // สร้างตัวแปร Fetch แสดงข้อมูลจากแถวทั้งหมด ออกมาจากการ Query ของตัวแปร '$item_list_query'
        // โดยเป็นการแสดงผลข้อมูลทั้งหมด โดยกำหนดว่า จะแสดงข้อมูลจาก Column ไหน
        $item_list_result = mysqli_fetch_all($item_list_query, MYSQLI_ASSOC);
    }

    // สร้างตัวแปร SQL เพื่อดึงข้อมูลจากตารางที่มีชื่อว่า 'rating_market' ที่มีข้อมูลในคอลัมน์ market_name มีเท่ากับ '$market_name' และ voter มีเท่ากับ '$username'
    $check_user_rating = "SELECT * FROM rating_market WHERE market_name = '$market_name' AND voter = '$username'";

    // สร้างตัวแปร Query แสดงผลข้อมูล
    // $conn คือตัวแปรจาก server.php ที่ใช้สำหรับการเชื่อมต่อฐานข้อมูล
    $check_user_rating_query = mysqli_query($conn, $check_user_rating);

    // สร้างตัวแปร Fetch แสดงข้อมูลจากแถวทั้งหมด ออกมาจากการ Query ของตัวแปร '$check_user_rating_query'
    // โดยเป็นการแสดงข้อมูลนั้นๆ โดยกำหนดว่า จะแสดงข้อมูลจาก Column ไหน
    $check_user_rating_result = mysqli_fetch_assoc($check_user_rating_query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $market_name ?></title>
    <link rel="stylesheet" href="market-style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>

    <nav>
        <div class="nav-content nav-left">
            <a href="index.php" class="nav-link">หน้าหลัก</a>
            <a href="guide.php" class="nav-link">เกี่ยวกับ</a>
            <a href="market.php?market_name=<?php echo $market_name ?>" class="nav-link nav-link-active">ร้านค้า</a>
        </div>
        <div class="nav-content nav-right">
            <?php if (isset($_SESSION['username'])) : ?>
                <a href="profile.php" class="nav-link"><?php echo $_SESSION['username'] ?></a>
                <a href="?logout='1'" class="nav-link">ออกจากระบบ</a>
            <?php else : ?>
                <a href="login.php" class="nav-link">เข้าสู่ระบบ</a>
                <a href="register.php" class="nav-link">สมัครสมาชิก</a>
            <?php endif ?>
        </div>
    </nav>

    <header>
        <h1><?php echo $market_name ?></h1>

        <?php if (isset($_SESSION['username'])) : ?>

            <?php if (empty($check_user_rating_result)) : ?>

                <?php if ($owner === $_SESSION['username'] || $check_user_result['role'] === 'admin') : ?>
                    
                <?php else : ?>

                    <form action="db/rating_market.php" method="get" class="box-rating">

                        <label for="rating">ให้คะแนนร้านค้า</label>

                        <input type="text" name="market_name" value="<?php echo $market_name ?>" readonly hidden>

                        <select name="rating-point">
                            <option value="5">5 คะแนน</option>
                            <option value="4">4 คะแนน</option>
                            <option value="3">3 คะแนน</option>
                            <option value="2">2 คะแนน</option>
                            <option value="1">1 คะแนน</option>
                        </select>

                        <button type="submit" class="btn">บันทึก</button>

                        <?php if (isset($_SESSION['error'])) : ?>
                            <p class="error">
                                <?php 
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                ?>
                            </p>
                        <?php endif ?>

                    </form>
                
                <?php endif ?>

            <?php endif ?>
            
        <?php endif ?>

    </header>

    <section>

        <div class="container">

            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" name="search-input" id="" placeholder="ค้นหา ...">
                <input type="submit" name="search" value="ค้นหาข้อมูล" class="btn">
            </form>
            
        </div>

        <div class="box-container">

            <p>สินค้า<b> <?php echo count($item_list_result) ?></b> รายการ (ทั้งหมด)</p>

            <?php if (isset($_SESSION['username'])) : ?>

                <?php if ($owner == $_SESSION['username']) : ?>

                    <p>
                        <a href="add_item.php?market_name=<?php echo $market_name ?>" class="btn">เพิ่มสินค้า</a>
                    </p>

                <?php endif ?>

            <?php endif ?>

            <?php if (isset($_SESSION['success'])) : ?>
                <p class="success">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </p>
            <?php endif ?>

            <?php if (isset($_SESSION['error'])) : ?>
                <p class="error">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </p>
            <?php endif ?>

            <?php foreach ($item_list_result as $item) : ?>
        
                <div class="box-item">

                    <div class="item-img">
                        <img src="<?php echo $item['item_img'] ?>" alt="<?php echo $item['item_name'] ?>">
                    </div>

                    <div class="item-desc">
                        <h2><?php echo $item['item_name'] ?></h2>
                        <p><?php echo nl2br($item['item_content']) ?></p>
                        <p>ราคา ฿<?php echo $item['item_price'] ?></p>
                        <p>หมวดหมู่ : <?php echo $item['item_category'] ?></p>
                        <p>ประเภท : <?php echo $item['item_type'] ?></p>
                    </div>

                    <div class="item-manage">
                        <?php if (isset($_SESSION['username'])) : ?>
                            <?php if ($owner == $_SESSION['username']) : ?>
                                <?php if (isset($_SESSION['success'])) : ?>
                                    <p class="success">
                                        <?php 
                                            echo $_SESSION['success'];
                                            unset($_SESSION['success']);
                                        ?>
                                    </p>
                                <?php endif ?>
                                <a href="edit_item.php?market_name=<?php echo $market_name ?>&item_id=<?php echo $item['item_id'] ?>" class="btn edit-market">แก้ไข</a>
                                <a href="delete_item.php?market_name=<?php echo $market_name ?>&item_id=<?php echo $item['item_id'] ?>" class="btn delete-market">ลบ</a>
                            <?php endif ?>
                        <?php endif ?>
                    </div>

                </div>

            <?php endforeach ?>

        </div>
    </section>
    <footer>
        <p>โรงเรียนมาบตาพุดพันพิทยาคาร</p>
        <p>สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาชลบุรี ระยอง</p>
    </footer>
</body>
</html>