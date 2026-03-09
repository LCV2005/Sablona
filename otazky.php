<?php
// Pole otázok
$otazky = array(
	"Aké sú vaše skúsenosti s PHP?",
	"Aký je váš obľúbený programovací jazyk?",
	"Aké sú vaše ciele pre túto stránku?",
	"Aké je najlepšie zviera?",
);

// Pole odpovedí
$odpovede = array(
	"Mám základné znalosti PHP a skúsenosti, ktoré neviem použiť.",
	"Môj obľúbený programovací jazyk bude určite PHP.",
	"Mojím cieľom je prejsť tento predmet.",
	"Odpoveď bude vždy kačica.",
);

// Ak je tento súbor otvorený priamo v prehliadači, vykresli aj akordeón.
if (basename(__FILE__) === basename($_SERVER['SCRIPT_FILENAME'])):
?>
<!DOCTYPE html>
<html lang="sk">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Otázky a odpovede</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/accordion.css">
</head>
<body>
	<main class="container" style="padding-top: 2rem; padding-bottom: 2rem;">
		<h1>Otázky a odpovede</h1>

		<?php for ($i = 0; $i < count($otazky); $i++) { ?>
			<div class="accordion">
				<div class="question"><?php echo htmlspecialchars($otazky[$i], ENT_QUOTES, 'UTF-8'); ?></div>
				<div class="answer"><?php echo htmlspecialchars($odpovede[$i], ENT_QUOTES, 'UTF-8'); ?></div>
			</div>
		<?php } ?>
	</main>

	<script src="js/accordion.js"></script>
</body>
</html>
<?php
endif;
?>
