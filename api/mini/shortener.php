<?php

namespace Shortener\Api\Minify;

use PDO;
use Shortener\Database\Config\Database;

class UrlShortener
{
    private $pdo;

    function __construct(){
        $this->pdo = Database::getInstance();
    }

    public function shortenUrl($url) {
        $stmt = $this->pdo->prepare("INSERT INTO links(url, url_code, date_added) VALUES (?, ?, CURDATE())");
        $hashedCode = strtoupper($this->hashUrl($url));
        return $stmt->execute([$url, $hashedCode]) ? $hashedCode : null;
    }

    private function hashUrl($url) {
        return hash("crc32", $url);
    }

    public function isUrlExists($url) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM links WHERE url = ?");
        if ($stmt->execute([$url])) {
            return intval($stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"]) > 0;
        }

        return false;
    }

    public function getExistingUrlCode($url) {
        $stmt = $this->pdo->prepare("SELECT url_code FROM links WHERE url = ? LIMIT 1");
        if ($stmt->execute([$url]) && $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $result["url_code"];
        }

        return null;
    }

    public function getUrlFromCode($urlCode) {
        $stmt = $this->pdo->prepare("SELECT url FROM links WHERE url_code = ? LIMIT 1");
        if ($stmt->execute([$urlCode]) && $result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return $result["url"];
        }

        return null;
    }
}
