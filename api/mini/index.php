<?php

use Shortener\Api\Minify\UrlShortener;

require "../db/config.php";
require "shortener.php";

$url = $_POST["longUrl"];

$output = [
    "success" => false,
    "message" => "",
    "code" => ""
];

if (filter_var($url, FILTER_VALIDATE_URL)) {

    $host = str_replace("www.", "", $_SERVER['SERVER_NAME']);

    if (strpos($url, $host) === false) {
        $output["success"] = true;

        $sh = new UrlShortener();

        if ($sh->isUrlExists($url)) {
            $output["code"] = $sh->getExistingUrlCode($url);
        } else {
            $output["code"] = $sh->shortenUrl($url);
        }
    } else {
        $output["message"] = "URl cannot be of the same server";
    }

} else {
    $output["message"] = "Invalid URL supplied";
}

echo json_encode($output);
