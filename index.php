<?php
    session_start();
    include('db/server.php');

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: index.php');
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        $check_user = "SELECT * FROM user WHERE username = '$username'";
        $check_user_query = mysqli_query($conn, $check_user);
        $check_user_result = mysqli_fetch_assoc($check_user_query);
    }

    $show_market = "SELECT * FROM market_list";
    $show_market_query = mysqli_query($conn, $show_market);
    $show_market_result = mysqli_fetch_all($show_market_query, MYSQLI_ASSOC);

    if (isset($_GET['edit_market_id'])) {
        $edit_market_id = $_GET['edit_market_id'];
        $edit_market = "SELECT * FROM market_list WHERE market_id = $edit_market_id";
        $edit_market_query = mysqli_query($conn, $edit_market);
        $edit_market_result = mysqli_fetch_assoc($edit_market_query);
    }

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>มาบตาพุดพัน มาร์เก็ตเพลส | Mapputphan Marketplace</title>
    <link rel="stylesheet" href="index-style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <nav>
        <div class="nav-content nav-left">
            <a href="index.php" class="nav-link nav-link-active">หน้าหลัก</a>
            <a href="guide.php" class="nav-link">เกี่ยวกับ</a>
            <a href="index.php#marketplace" class="nav-link">ร้านค้า</a>
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
        <h1>มาบตาพุดพัน มาร์เก็ตเพลส | Mapputphan Marketplace</h1>
        <p>เว็ปไซต์รวบรวมร้านค้าภายในโรงเรียนมาบตาพุดพันพิทยาคาร</p>
    </header>

    <section id="marketplace">
       <h1>ร้านค้า (ทั้งหมด)</h1>
       <div class="container">

            <div class="box-container">

                <?php foreach ($show_market_result as $market) : ?>
    
                    <div class="box market-box">
    
                        <div class="img-box">
                            <img src="<?php echo $market['market_img'] ?>" alt="ภาพ <?php echo $market['market_name'] ?>">
                        </div>
    
                        <h2><?php echo $market['market_name'] ?></h2>
                        <p><?php echo $market['market_content'] ?></p>
                        <p>เบอร์ติดต่อ : <?php echo $market['market_contact'] ?></p>
                        <p>คะแนนนิยม (ทั้งหมด) : <b><?php echo $market['market_point'] ?></b> คะแนน</p>

                        <?php if (!empty($_SESSION['username'])) : ?>

                            <?php if ($check_user_result['role'] === "admin") : ?>

                                <p>เจ้าของร้าน : <?php echo $market['owner'] ?></p>
                                <div class="admin-box">
                                    <a href="edit_market.php?edit_market_id=<?php echo $market['market_id'] ?>&market_name=<?php echo $market['market_name'] ?>" class="btn edit-market">เปลี่ยนเจ้าของร้าน</a>
                                    <a href="delete_market.php?delete_market_id=<?php echo $market['market_id'] ?>" class="btn delete-market">ลบร้านค้า</a>
                                </div>

                            <?php elseif ($market['owner'] === $_SESSION['username']) : ?>

                                <p>
                                    <b>คุณเป็นเจ้าของร้านนี้</b>
                                </p>

                                <div class="admin-box">
                                    <?php if (isset($_SESSION['success'])) : ?>
                                        <p class="success">
                                            <?php 
                                            echo $_SESSION['success'];
                                            unset($_SESSION['success']);
                                            ?>
                                         </p>
                                    <?php endif ?>
                                        
                                    <a href="edit_market.php?edit_market_id=<?php echo $market['market_id'] ?>&market_name=<?php echo $market['market_name'] ?>" class="btn edit-market">แก้ไขร้านค้า</a>

                                    <a href="delete_market.php?delete_market_id=<?php echo $market['market_id'] ?>" class="btn delete-market">ลบร้านค้า</a>
                                </div>
                            <?php endif ?>

                        <?php endif ?> 

                        <div class="box-button">
                            <a href="market.php?market_name=<?php echo $market['market_name'] ?>" class="btn default">เยี่ยมชมร้านค้า</a>
                        </div>
    
                    </div>
    
                <?php endforeach ?>

            </div>

       </div>
    </section>

    <footer>
        <p>โรงเรียนมาบตาพุดพันพิทยาคาร</p>
        <p>สำนักงานเขตพื้นที่การศึกษามัธยมศึกษาชลบุรี ระยอง</p>
    </footer>
</body>
</html>