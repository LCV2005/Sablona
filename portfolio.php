<?php
$pageTitle = 'Portfólio';
$pageStyles = ['css/banner.css', 'css/portfolio.css'];
require_once __DIR__ . '/header.php';

$portfolioProjects = [
    ['title' => 'Web stránka 1'],
    ['title' => 'Web stránka 2'],
    ['title' => 'Web stránka 3'],
    ['title' => 'Web stránka 4'],
    ['title' => 'Web stránka 5'],
    ['title' => 'Web stránka 6'],
    ['title' => 'Web stránka 7'],
    ['title' => 'Web stránka 8'],
];

function generatePortfolioCards(array $projects, int $columns = 4): string
{
    $html = '';
    $count = count($projects);

    for ($i = 0; $i < $count; $i++) {
        if ($i % $columns === 0) {
            $html .= "        <div class=\"row\">\n";
        }

        $id = 'portfolio-' . ($i + 1);
        $title = htmlspecialchars($projects[$i]['title'], ENT_QUOTES, 'UTF-8');

        $html .= "          <div class=\"col-25 portfolio text-white text-center\" id=\"{$id}\">\n";
        $html .= "              {$title}\n";
        $html .= "          </div>\n";

        if (($i + 1) % $columns === 0 || $i === $count - 1) {
            $html .= "        </div>\n";
        }
    }

    return $html;
}
?>

        <main>
            <section class="banner">
                <div class="container text-white">
                    <h1>Portfólio</h1>
                </div>
            </section>
              <section class="container">
<?= generatePortfolioCards($portfolioProjects); ?>
            </section>

        </main>
    <script src="js/menu.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>