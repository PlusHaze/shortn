<?php

namespace Shortener\Api\Report;

use PDO;
use Shortener\Database\Config\Database;

class UrlReport
{
    private $pdo;

    function __construct(){
        $this->pdo = Database::getInstance();
    }

    public function getTotalShortened() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM links");
        return $stmt->execute() ? intval($stmt->fetch(PDO::FETCH_ASSOC)["total"]) : 0;
    }

    public function getTotalShortenedToday() {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM links WHERE date_added = CURDATE()");
        return $stmt->execute() ? intval($stmt->fetch(PDO::FETCH_ASSOC)["total"]) : 0;
    }
}