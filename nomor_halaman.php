<?php
function generateNomorHalaman($total_data, $offset, $limit, $title, $release_date)
{
    $hasil = "";
    $hasil .= "<p style='display: inline; margin-top: 20px;'>";

    $query = "&title=$title&release_date=$release_date";

    $hasil .= "<a href='?offset=0$query'> First </a>";

    // Hitung maks halaman untuk mendapat nilai maksimal pagination
    $maks_hal = ceil($total_data / $limit);

    if ($maks_hal > 0) {
        // Cek apakah ada previous page, dengan menghitung apakah offset sekarang melebihi limit
        if ($offset >= $limit) {
            $hasil .= "<a href='?offset=" . ($offset - $limit) . $query . "'> Prev </a>";
        }

        // Isi pagination dengan nomor halaman terkecil 1 hingga maks halaman
        for ($nomor_hal = 1; $nomor_hal <= $maks_hal; $nomor_hal++) {
            $new_offset = ($nomor_hal - 1) * $limit;

            $hal_sekarang = ($offset / $limit) + 1;

            // Jika nomor halaman yang akan ditulis == halaman sekarang, ubah dari a href menjadi p biasa agar tidak bisa dipencet
            if ($nomor_hal == $hal_sekarang) {
                $hasil .= "<p style='display: inline;'>" . $nomor_hal . "</p>";
            } else {
                $hasil .= "<a href='?offset=" . $new_offset . $query . "'>" . $nomor_hal . "</a>";
            }

            $hasil .= "  ";
        }


        // Cek apakah masih ada next page dengan menghitung jumlah offset sekarang ditambah limit masih kurang dari total data yang ada
        if ($offset + $limit < $total_data) {
            $hasil .= "<a href='?offset=" . ($offset + $limit) . $query . "'> Next </a>";
        }
    }

    // Hitung max offset untuk membuat last page
    $max_offset = ($maks_hal - 1) * $limit;

    // Jika max offset bernilai negatif berarti kita sedang berada di last page
    if ($max_offset < 0) {
        $max_offset = 0;
    }

    $hasil .= "<a href='?offset=" . $max_offset . $query . "'> Last </a>";
    $hasil .= "</p>";

    return $hasil;
}
