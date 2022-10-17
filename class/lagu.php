<?php
require_once("db.php");

class lagu
{
    public function get_singer()
    {
        $sql = "SELECT * FROM singers";

        $stmt = db::get_connection()->prepare($sql);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function get_specific_lagu($song_id)
    {
        $sql = "SELECT * FROM songs WHERE id=?";
        $stmt = db::get_connection()->prepare($sql);
        $stmt->bind_param("i", $song_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function add_lagu($lagu)
    {
        extract($lagu);

        $sql = "INSERT INTO songs(title, releasedate, totalsold, singers_id) VALUES (?,?,?,?)";
        $stmt = db::get_connection()->prepare($sql);

        $stmt->bind_param("ssii", $title, $release_date, $totalsold, $singers_id);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function update_lagu($lagu)
    {
        extract($lagu);

        $sql = "UPDATE songs SET title=?, releasedate=?, totalsold=?, singers_id=? WHERE id=?";
        $stmt = db::get_connection()->prepare($sql);

        $stmt->bind_param("ssiii", $title, $release_date, $totalsold, $singers_id, $song_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function get_lagu($title, $release_date, $offset = null, $limit = null)
    {
        $sql = "SELECT * FROM songs WHERE title LIKE ? AND releasedate LIKE ?";

        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }

        $stmt = db::get_connection()->prepare($sql);

        $title = "%" . $title . "%";
        $release_date = "%" . $release_date . "%";

        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param("ssii", $title, $release_date, $offset, $limit);
        } else {
            $stmt->bind_param("ss", $title, $release_date);
        }

        $stmt->execute();
        return $stmt->get_result();
    }

    public function delete_lagu($song_id)
    {
        $sql = "DELETE FROM songs WHERE id=?";
        $stmt = db::get_connection()->prepare($sql);

        $stmt->bind_param("i", $song_id);
        $stmt->execute();
        return $stmt->affected_rows;
    }

    public function get_jumlah_data($title, $release_date)
    {
        return $this->get_lagu($title, $release_date)->num_rows;
    }
}
