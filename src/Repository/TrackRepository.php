<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 14.15
 */

namespace Radioactive\Repository;


use Radioactive\Model\Author;
use Radioactive\Model\Track;

class TrackRepository
{
    private $_pdo;

    public function __construct(\PDO $pdo)
    {
        $this->_pdo = $pdo;
    }

    public function getIds(): array
    {
        $statement = $this->_pdo->query('SELECT (id) FROM tracks');
        $rows = $statement->fetchAll();
        $idList = array_map(function ($row) {
            return $row['id'];
        }, $rows);

        return $idList;
    }

    public function get(int $id): Track
    {
        $statement = $this->_pdo->query('SELECT
          tracks.id AS track_id,
          tracks.name AS track_name,
          tracks.duration AS track_duration,
          tracks.preview AS track_preview,
          tracks.body AS track_body,
          authors.id AS author_id,
          authors.name AS author_name,
          authors.foundation_date AS author_foundation_date
          FROM tracks INNER JOIN authors ON tracks.author_id = authors.id
          WHERE tracks.id = ' . $id);
        $row = $statement->fetch();

        $track = new Track();
        $track->setId($row['track_id']);
        $track->setName($row['track_name']);
        $track->setDuration($row['track_duration']);
        $track->setPreview($row['track_preview']);
        $track->setBody($row['track_body']);

        $author = new Author();
        $author->setId($row['author_id']);
        $author->setName($row['author_name']);
        $author->setFoundationDate($row['author_foundation_date']);

        $track->setAuthor($author);

        return $track;
    }
}