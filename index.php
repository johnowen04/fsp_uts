<?php
require_once("class/lagu.php");
$obj_lagu = new lagu();

if (isset($_GET['delete_status'])) {
    if ($_GET['delete_status']) {
        echo "Lagu dihapus.";
    } else {
        echo "Lagu gagal dihapus.";
    }
}

if (isset($_GET['insert_id'])) {
    $inserted_lagu = $obj_lagu->get_specific_lagu($_GET['insert_id']);
    while ($row = $inserted_lagu->fetch_assoc()) {
        echo "Lagu berjudul " . $row['title'] . " berhasil dimasukkan.";
    }
}

if (isset($_GET['update_status'])) {
    if ($_GET['update_status'] == 1) {
        echo "Lagu telah berhasil diupdate.";
    } else if (!$_GET['update_status']) {
        echo "Lagu gagal diupdate.";
    }
}

$res_singer = $obj_lagu->get_singer();

$arr_singer = array();

while ($row = $res_singer->fetch_assoc()) {
    $arr_singer[$row['id']] = $row['name'];
}

function format_date($param_date)
{
    $date = strtotime($param_date);
    $formatted_date = date("d M Y", $date);
    return $formatted_date;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <style type="text/css">
        table,
        th,
        tr,
        td {
            border: 1px solid black;
        }
    </style>
</head>

<body>
    <h1>Song Lists</h1>
    <form method='get'>
        <p>Masukkan judul lagu:
            <input type="text" name="title">
        </p>

        <p>Masukkan tanggal rilis:
            <input type='date' name='release_date'>
        </p>

        <p><input type='submit' value='Search'></p>
    </form>
    <?php
    $placeholder = "Hasil pencarian lagu dengan";

    if (isset($_GET['title'])) {
        $title = $_GET['title'];
    } else {
        $title = "";
    }

    if (isset($_GET['release_date'])) {
        $release_date = $_GET['release_date'];
    } else {
        $release_date = "";
    }

    if (!empty($title)) {
        $placeholder .= " judul " . $title;
    }

    if (!empty($release_date)) {
        $placeholder .= " tanggal rilis " . format_date($release_date);
    }

    if (!empty($title) OR !empty($release_date)) {
        echo "<p><i>$placeholder</i></p>";
    }

    echo "<p><a href='insert_lagu.php'>Tambah Lagu</a></p>";

    $limit = 10;
    if (!isset($_GET['offset']) OR !is_numeric($_GET['offset'])) {
        $offset = 0;
    } else {
        $offset = $_GET['offset'];
    }

    $res_lagu = $obj_lagu->get_lagu($title, $release_date, $offset, $limit);

    echo "<table>
            <tr>
                <th>Title</th>
                <th>Release Date</th>
                <th>Total Sold</th>
                <th>Singer</th>
                <th>Action</th>
            </tr>";

    while ($row = $res_lagu->fetch_assoc()) {
        echo "<tr>";

        echo "<td>" . $row['title'] . "</td>";

        echo "<td>" . format_date($row['releasedate']) . "</td>";

        echo "<td>" . $row['totalsold'] . "</td>";

        echo "<td>" . $arr_singer[$row['singers_id']] . "</td>";

        echo "<td>";
        echo "<form action='update_lagu.php' method='post'>";
        echo "<input type='hidden' name='song_id' value=" . $row['id'] . ">";
        echo "<input type='submit' value='Update'>";
        echo "</form>";
        echo "<br>";
        echo "<form action='delete_lagu.php' method='post'>";
        echo "<input type='hidden' name='song_id' value=" . $row['id'] . ">";
        echo "<input type='submit' value='Delete'>";
        echo "</form>";
        echo "</td>";

        echo "</tr>";
    }
    echo "<table>";

    $total_data = $obj_lagu->get_jumlah_data($title, $release_date);
    include 'nomor_halaman.php';
    echo "<br>";
    echo generateNomorHalaman($total_data, $offset, $limit, $title, $release_date);
    ?>
</body>

</html>