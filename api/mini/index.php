<?php

require "../db/config.php";
require "shortener.php";

$url = $_POST["longUrl"];

$output = [
    "success" => false,
    "message" => "",
    "code" => ""
];

if (filter_var($url, FILTER_VALIDATE_URL)) {
    $output["success"] = true;

    $sh = new UrlShortener();

    if ($sh->isUrlExists($url)) {
        $output["code"] .= $sh->getExistingUrlCode($url);
    } else {
        $output["code"] .= $sh->shortenUrl($url);
    }
} else {
    $output["message"] = "Invalid URL supplied";
}

echo json_encode($output);