<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle ?? 'Moja stránka', ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="css/style.css">
  <?php foreach ($pageStyles ?? [] as $style): ?>
  <link rel="stylesheet" href="<?= htmlspecialchars($style, ENT_QUOTES, 'UTF-8') ?>">
  <?php endforeach; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<header class="container main-header">
  <div class="logo-holder">
    <a href="index.php"><img src="img/logo.png" height="40"></a>
  </div>
  <nav class="main-nav">
    <ul class="main-menu" id="main-menu">
      <li><a href="index.php">Domov</a></li>
      <li><a href="portfolio.php">Portfólio</a></li>
      <li><a href="qna.php">Q&A</a></li>
      <li><a href="kontakt.php">Kontakt</a></li>
    </ul>
    <a class="hamburger" id="hamburger">
      <i class="fa fa-bars"></i>
    </a>
  </nav>
</header>
