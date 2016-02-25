<?php

class UrlShortener {

    private $pdo;

    function __construct(){
        $this->pdo = Database::getInstance();
    }

    public function shortenUrl($url) {
        $stmt = $this->pdo->prepare("INSERT INTO links(url, url_code, date_added) VALUES (?, ?, CURDATE());");
        $hashedCode = strtoupper($this->hashUrl($url));
        return $stmt->execute([$url, $hashedCode]) ? $hashedCode : null;
    }

    private function hashUrl($url) {
        return hash("crc32", $url);
    }

    public function isUrlExists($url) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM links WHERE url = ?;");
        if ($stmt->execute([$url])) {
            return intval($stmt->fetch(PDO::FETCH_ASSOC)["COUNT(*)"]) > 0;
        }

        return false;
    }

    public function getExistingUrlCode($url) {
        $stmt = $this->pdo->prepare("SELECT url_code FROM links WHERE url = ? LIMIT 1");
        if ($stmt->execute([$url]) && $stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC)["url_code"];
        }

        return null;
    }

    public function getUrlFromCode($urlCode) {
        $stmt = $this->pdo->prepare("SELECT url FROM links WHERE url_code = ? LIMIT 1");
        if ($stmt->execute([$urlCode]) && $stmt->rowCount() == 1) {
            return $stmt->fetch(PDO::FETCH_ASSOC)["url"];
        }

        return null;
    }
}