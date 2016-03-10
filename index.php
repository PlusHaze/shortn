<?php

use Shortener\Api\Minify\UrlShortener;

if (isset($_GET["code"])) {

    require "api/db/config.php";
    require "api/mini/shortener.php";

    $sh = new UrlShortener();

    $url = $sh->getUrlFromCode($_GET["code"]);
    $host = str_replace("www.", "", $_SERVER["SERVER_NAME"]);

    if ($url != null && strpos($url, $host) === false) {
        header("location: " . $url);
    } else {
        header("location: /" . basename(__DIR__));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="assets/include/bootstrap/bootsrap.min.css">
    <script src="assets/include/bootstrap/boostrap-3.3.6.js"></script>
    <script src="assets/include/jquery/jquery-1.12.0.js"></script>
    <link rel="stylesheet" href="assets/css/core.css">
    <title>Shortn - URL Shortener</title>
</head>
<body>
<div class="container">

    <div class="page-header">
        <h1 id="headerTitle" >Shortn -
            <small id="slur">Shorten your URL today!</small>
        </h1>
    </div>

    <section class="center">

        <form>
            <input id="btnSubmit" type="submit" class="btn btn-primary" value="Shortn"/>
            <div class="form-group inline-form">
                <input id="inputUrl" type="url" class="form-control" placeholder="Enter URL here"/>
            </div>
        </form>

        <div class="alert alert-success hidden" role="alert">
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong>URL shortened successfully.</strong>
            <p id="txtSuccess"></p>
        </div>

        <div class="alert alert-danger hidden" role="alert">
            <button type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <strong id="txtError"></strong>
        </div>
        <br>

        <div id="statistics-panel" class="panel panel-info center">
            <div class="panel-heading">
                <h3 class="panel-title">Page Statistics</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span id="totalShortened" class="badge">0</span>
                        Total URLs shortened
                    </li>

                    <li class="list-group-item">
                        <span id="shortenedToday" class="badge">0</span>
                        Total URLs shortened today
                    </li>
                </ul>
            </div>
        </div>
    </section>
</div>

<script src="assets/js/main.js"></script>
</body>
</html>
