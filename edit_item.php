<?php 
    include('db/server.php');
    include('db/check_user.php');

    $error = array();

    $market_name = $_GET['market_name'];
    $item_id = $_GET['item_id'];
    $item_category_list = array("อาหารคาว", "อาหารหวาน");
    $item_type_list = array("ผัด", "ยำ", "ทอด / เผา / ย่าง", "เครื่องจิ้ม", "เครื่องเคียง ");


    $item_list = "SELECT * FROM $market_name WHERE item_id = $item_id";
    $item_list_query = mysqli_query($conn, $item_list);
    $item_list_result = mysqli_fetch_all($item_list_query, MYSQLI_ASSOC);

    if (isset($_POST['save'])) {

        $item_name_input = mysqli_real_escape_string($conn, $_POST['item_name']);
        $item_content_input = mysqli_real_escape_string($conn, $_POST['item_content']);
        $item_price_input = mysqli_real_escape_string($conn, $_POST['item_price']);
        $item_category_input = mysqli_real_escape_string($conn, $_POST['item_category']);
        $item_type_input = mysqli_real_escape_string($conn, $_POST['item_type']);

        $dir = "img/upload/item_list/";
        $fileImage = $dir . basename($_FILES['item_img']['name']);

        if (move_uploaded_file($_FILES['item_img']['tmp_name'], $fileImage) || isset($_POST['item_name']) || isset($_POST['item_content'])) {

            if (empty($_FILES['item_img']['tmp_name'])) {
                $update_item = "UPDATE $market_name SET item_name = '$item_name_input', item_content = '$item_content_input', item_price = '$item_price_input', item_category = '$item_category_input', item_type = '$item_type_input' WHERE item_id = $item_id";
                mysqli_query($conn, $update_item);
            } else {
                $update_item = "UPDATE $market_name SET item_img = '$fileImage', item_name = '$item_name_input', item_content = '$item_content_input', item_price = '$item_price_input', item_category = '$item_category_input', item_type = '$item_type_input' WHERE item_id = $item_id";
                mysqli_query($conn, $update_item);
            }

            $_SESSION['success'] = "อัพเดตข้อมูลสินค้าสำเร็จ";
            header('location: market.php?market_name='. $market_name);

        } else {
            array_push($error, "อัพเดตข้อมูลสินค้าไม่สำเร็จ");
            $_SESSION['error'] = "อัพเดตข้อมูลสินค้าไม่สำเร็จ";
            header('location: edit_item.php?market_name=' . $market_name . "&item_id=" . $item_id);
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขสินค้า | <?php echo $market_name ?></title>
    <link rel="stylesheet" href="edit-style.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>

    <header>

        <h2>แก้ไขสินค้า | <?php echo $market_name ?></h2>

    </header>

    <section>
        <?php foreach ($item_list_result as $item) : ?>
    
            <div class="box-item">

                <form action="" method="post" enctype="multipart/form-data">

                    <div class="item-img">

                        <img src="<?php echo $item['item_img'] ?>" alt="<?php echo $item['item_name'] ?>" id="previewImg">

                    </div>

                    <div class="item-desc">

                        <p class="label">รูปภาพ</p>

                        <p>
                            <input type="file" name="item_img" id="item_img">
                        </p>

                        <p class="label">ชื่อสินค้า</p>

                        <p>
                            <input type="text" name="item_name" value="<?php echo $item['item_name'] ?>">
                        </p>

                        <p class="label">รายละเอียด</p>

                        <p>
                            <textarea name="item_content"><?php echo nl2br($item['item_content']) ?></textarea>
                        </p>

                        <p class="label">ราคา (บาท)</p>

                        <p>
                            <input type="number" name="item_price" value="<?php echo $item['item_price'] ?>">
                        </p>

                        <p class="label">หมวดหมู่</p>

                        <p>
                            <select name="item_category">
                                <?php foreach ($item_category_list as $item_category) : ?>
                                    <?php if ($item['item_category'] == $item_category) : ?>
                                        <option value="<?php echo $item_category ?>" selected><?php echo $item_category ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $item_category ?>"><?php echo $item_category_list ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>    
                            </select>
                        </p>

                        <p class="label">ประเภท</p>

                        <p>
                            <select name="item_type">
                                <?php foreach ($item_type_list as $item_type) : ?>
                                    <?php if ($item['item_type'] == $item_type) : ?>
                                        <option value="<?php echo $item_type ?>" selected><?php echo $item_type ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $item_type ?>"><?php echo $item_type ?></option>
                                    <?php endif ?>
                                <?php endforeach ?>   
                            </select>
                        </p>

                        <p>
                            <button type="submit" name="save" class="btn">บันทึก</button>
                            <a href="market.php?market_name=<?php echo $market_name ?>" class="btn">ย้อนกลับ</a>
                        </p>

                    </div>

                    <?php if (isset($_SESSION['error'])) : ?>
                        <p class="error">
                            <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            ?>
                        </p>
                    <?php endif ?>

                </form>
            </div>
    
        <?php endforeach ?>
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