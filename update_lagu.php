<?php
require_once("class/lagu.php");

$obj_lagu = new lagu();

if (!isset($_POST['song_id'])) {
    header("location: index.php");
}

$res_lagu = $obj_lagu->get_specific_lagu($_POST['song_id']);

$chosen_lagu = $res_lagu->fetch_assoc();

$res_singer = $obj_lagu->get_singer();

$arr_singer = array();

while ($row = $res_singer->fetch_assoc()) {
    $arr_singer[$row['id']] = $row['name'];
}

if (isset($_POST['btnUpdateLagu'])) {
    if (empty($_POST['title'])) {
        $error = 'Title cannot be empty';
    } else if (empty($_POST['release_date'])) {
        $error = 'Release Date cannot be empty';
    } else if (empty($_POST['totalsold'])) {
        $error = 'Total Sold cannot be empty';
    } else if (empty($_POST['singers_id'])) {
        $error = 'Singer cannot be empty';
    } else {
        if (is_numeric($_POST['totalsold'])) {
            $error = 'Total sold must be a number';
        } else {
            $obj_lagu = new lagu();
            $lagu = array(
                'song_id' => $_POST['song_id'],
                'title' => htmlentities($_POST['title']),
                'release_date' => $_POST['release_date'],
                'totalsold' => $_POST['totalsold'],
                'singers_id' => $_POST['singers_id'],
            );
            $affected = $obj_lagu->update_lagu($lagu);

            header("location: index.php?update_status=$affected");
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
    <title>Update Lagu</title>
</head>

<body>
    <form method="post">
        <?php
        echo "<p>Title: <input type='text' name='title' value='" . $chosen_lagu['title'] . "'></p>";
        echo "<p>Release Date: <input type='date' name='release_date' value='" . $chosen_lagu['releasedate'] . "'></p>";
        echo "<p>Total Sold: <input type='number' name='totalsold' value='" . $chosen_lagu['totalsold'] . "'></p>";
        echo "<p>Singer: ";
        echo "<select name='singers_id' id='selSinger'>";
        echo "<option value=''>-- Choose Singer --</option>";
        foreach ($arr_singer as $id => $name) {
            if ($id == $chosen_lagu['singers_id']) {
                echo "<option value='" . $id . "' selected>" . $name . "</option>";
            } else {
                echo "<option value='" . $id . "'>" . $name . "</option>";
            }
        }
        echo "</select>";
        echo "</p>";
        echo "<p><input type='hidden' name='song_id' value='" . $_POST['song_id'] . "'></p>"
        ?>
        <p><input type='submit' name='btnUpdateLagu' value='Update'></p>
    </form>
</body>

</html>