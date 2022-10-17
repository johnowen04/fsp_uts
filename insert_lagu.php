<?php
require_once("class/lagu.php");

$obj_lagu = new lagu();
$res_singer = $obj_lagu->get_singer();

$arr_singer = array();

while ($row = $res_singer->fetch_assoc()) {
    $arr_singer[$row['id']] = $row['name'];
}

if (isset($_POST['btnInsertLagu'])) {
    if (empty($_POST['title'])) {
        $error = 'Title cannot be empty';
    } else if (empty($_POST['release_date'])) {
        $error = 'Release Date cannot be empty';
    } else if (empty($_POST['totalsold'])) {
        $error = 'Total Sold cannot be empty';
    } else if (empty($_POST['singers_id'])) {
        $error = 'Singer cannot be empty';
    } else {
        if (!is_numeric($_POST['totalsold'])) {
            $error = 'Total sold must be a number';
        } else {
            $obj_lagu = new lagu();
            $lagu = array(
                'title' => htmlentities($_POST['title']),
                'release_date' => $_POST['release_date'],
                'totalsold' => $_POST['totalsold'],
                'singers_id' => $_POST['singers_id'],
            );
            $insert_id = $obj_lagu->add_lagu($lagu);

            header("location: index.php?insert_id=$insert_id");
        }
    }

    if (isset($error)) {
        echo $error;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lagu</title>
</head>

<body>
    <form method="post">
        <p>Title: <input type="text" name="title"></p>
        <p>Release Date: <input type="date" name="release_date"></p>
        <p>Total Sold: <input type="number" name="totalsold"></p>
        <p>Singer:
            <select name='singers_id' id='selSinger'>
                <option value=''>-- Choose Singer --</option>
                <?php
                foreach ($arr_singer as $id => $name) {
                    echo "<option value='" . $id . "'>" . $name . "</option>";
                }
                echo "</select>";
                ?>
        </p>
        <p><input type='submit' name='btnInsertLagu' value='Insert'></p>
    </form>
</body>

</html>