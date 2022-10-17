<?php
require_once("class/lagu.php");
$obj_lagu = new lagu();

if (isset($_POST['song_id'])) {
    $song_id = $_POST['song_id'];
    $affected = $obj_lagu->delete_lagu($song_id);
}

header("location: index.php?delete_status=$affected");
