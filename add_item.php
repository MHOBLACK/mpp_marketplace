<?php 
    session_start();
    include('db/server.php');

    $market_name = $_GET['market_name'];

    $error = array();

    if (isset($_POST['add-item'])) {

        $item_name = mysqli_real_escape_string($conn, $_POST['item_name']);
        $item_content = mysqli_real_escape_string($conn, $_POST['item_content']);
        $item_price = mysqli_real_escape_string($conn, $_POST['item_price']);
        
        $item_category = mysqli_real_escape_string($conn, $_POST['item_category']);
        $item_type = mysqli_real_escape_string($conn, $_POST['item_type']);

        $dir = "img/upload/item_list/";
        $fileImage = $dir . basename($_FILES['item_img']['name']);

        if (move_uploaded_file($_FILES['item_img']['tmp_name'], $fileImage)) {

            $insert_item = "INSERT INTO $market_name (item_img, item_name, item_content, item_price, item_category, item_type) VALUES ('$fileImage' ,'$item_name', '$item_content', ' $item_price', '$item_category', '$item_type')";
            mysqli_query($conn, $insert_item);

            header('location: market.php?market_name=' . $market_name);
            $_SESSION['success'] = "เพิ่มสินค้าสำเร็จ";
        } else {
            array_push($error, "เพิ่มข้อมูลไม่สำเร็จ");
            $_SESSION['error'] = "เพิ่มข้อมูลไม่สำเร็จ";
            header('location: add_item.php?market_name=' . $market_name);
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มสินค้า | <?php echo $market_name ?></title>
    <link rel="stylesheet" href="add-style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <header>
        <h1>เพิ่มสินค้า | <?php echo $market_name ?></h1>
    </header>
    <section>
        <div class="container">

            <form action="" method="post" enctype="multipart/form-data" >

                <h2>เพิ่มสินค้า</h2>
                
                    <div class="img-box">
                        <img id="previewImg">
                    </div>

                    <p class="label">รูปภาพ</p>

                    <p>
                        <input type="file" name="item_img" id="item_img" accept="image/*" required>
                    </p>

                    <p class="label">ชื่อสินค้า</p>

                    <p>
                        <input type="text" name="item_name" placeholder="ชื่อสินค้า" required>
                    </p>

                    <p class="label">รายละเอียด</p>

                    <p>
                        <textarea name="item_content" cols="30" rows="10" placeholder="คำอธิบาย" required></textarea>
                    </p>

                    <p class="label">ราคา (บาท)</p>

                    <p>
                        <input type="number" name="item_price" placeholder="จำนวนเงิน" required>
                    </p>

                    <p class="label">หมวดหมู่</p>

                    <p>
                        <select name="item_category">
                            <option value="อาหารคาว">อาหารคาว</option>
                            <option value="อาหารหวาน">อาหารหวาน</option>
                        </select>
                    </p>

                    <p class="label">ประเภท</p>

                    <p>
                        <select name="item_type">
                            <option value="ผัด">ผัด</option>
                            <option value="แกง">แกง</option>
                            <option value="ยำ">ยำ</option>
                            <option value="ทอด / เผา / ย่าง">ทอด / เผา / ย่าง</option>
                            <option value="เครื่องจิ้ม">เครื่องจิ้ม</option>
                            <option value="เครื่องเคียง">เครื่องเคียง</option>
                        </select>
                    </p>

                    <p>
                        <button type="submit" name="add-item" class="btn">เพิ่มสินค้า</button>
                    </p>

            </form>

        </div>
    </section>

    <script>
        let imgInput = document.querySelector('#item_img');
        let previewImg = document.querySelector('#previewImg');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
</body>
</html>