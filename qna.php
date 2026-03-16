<?php
$pageTitle = 'Q&A';
$pageStyles = ['css/banner.css', 'css/accordion.css'];
include 'header.php';
?>
  <main>
    <section class="banner">
      <div class="container text-white">
        <h1>Q&A</h1>
      </div>
    </section>
    <section class="container">
      <div class="row">
        <div class="col-100 text-center">
          <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam qui. Mollit deserunt culpa incididunt laborum commodo in culpa.</em></strong></p>
        </div>
      </div>
    </section>
    <section class="container">
      <?php include "otazky.php"; ?>
      <?php for ($i = 0; $i < count($otazky); $i++) { ?>
        <div class="accordion">
          <div class="question"><?php echo htmlspecialchars($otazky[$i], ENT_QUOTES, "UTF-8"); ?></div>
          <div class="answer"><?php echo htmlspecialchars($odpovede[$i], ENT_QUOTES, "UTF-8"); ?></div>
        </div>
      <?php } ?>
    </section>
  </main>
<script src="js/accordion.js"></script>
<script src="js/menu.js"></script>
<?php include 'footer.php'; ?>