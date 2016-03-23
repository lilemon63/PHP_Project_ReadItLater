<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <link href="viewIndex.css" rel="stylesheet" />
    <title>ReadItLater - Home</title>
</head>
<body>
    <header>
        <h1>ReadItLater</h1>
    </header>
    <?php foreach ($links as $link): ?>
    <article>
        <h2><?php echo $link->getUrl() ?></h2>
        <p><?php echo $link->getStatus() ?></p>
    </article>
    <?php endforeach ?>
    <footer class="footer">
		Fait par Maxime Mikotajewski et Damien Morel
    </footer>
</body>
</html>
