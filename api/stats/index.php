<?php

use Shortener\Api\Report\UrlReport;

require "../db/config.php";
require "urlreport.php";

$stats = new UrlReport();

$data = [
    "total_shortened" => $stats->getTotalShortened(),
    "shortened_today" => $stats->getTotalShortenedToday()
];

echo json_encode($data);