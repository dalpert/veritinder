<!DOCTYPE html>

<html>

    <head>

        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>VeriTinder: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>VeriTinder</title>
        <?php endif ?>

        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>

    </head>
    

    <body>
    <style>
    body { background-image: url("../img/grey_wash_wall.png"); }
    </style>

        <div class="container">
            <br>
            <div id="top">
                <a href="http://veritinder.com/"><img alt="VeriTinder" src="/img/veritinder.png"/></a>
            </div>
        <div id="middle">
