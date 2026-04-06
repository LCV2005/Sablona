<?php
declare(strict_types=1);

/**
 * Overí, či je zadaný typ menu platný.
 *
 * @param string $type
 * @return bool
 */
function validateMenuType(string $type): bool {
    $menuTypes = ['header', 'footer'];
    return in_array($type, $menuTypes, true);
}

/**
 * Vráti asociatívne pole s položkami menu podľa typu.
 *
 * Každá položka má kľúče: 'name' a 'path'
 *
 * @param string $type
 * @return array
 */
function getMenuData(string $type = 'header'): array {
    if (!validateMenuType($type)) {
        return [];
    }

    $menu = [];

    if ($type === 'header') {
        $menu = [
            'home' => ['name' => 'Domov', 'path' => '/index.php'],
            'portfolio' => ['name' => 'Portfólio', 'path' => '/portfolio.php'],
            'qna' => ['name' => 'Otázky', 'path' => '/qna.php'],
            'kontakt' => ['name' => 'Kontakt', 'path' => '/kontakt.php'],
        ];
    } elseif ($type === 'footer') {
        $menu = [
            'privacy' => ['name' => 'Ochrana súkromia', 'path' => '/privacy.php'],
            'terms' => ['name' => 'Podmienky', 'path' => '/terms.php'],
            'contact' => ['name' => 'Kontakt', 'path' => '/kontakt.php'],
        ];
    }

    return $menu;
}

/**
 * Vytlačí HTML pre navigačné menu na základe poľa z getMenuData().
 *
 * @param array $menu
 * @param string $ulClass voliteľná trieda pre <ul>
 * @return void
 */
function printMenu(array $menu, string $ulClass = ''): void {
    $ulClassAttr = $ulClass !== '' ? ' class="' . htmlspecialchars($ulClass, ENT_QUOTES) . '"' : '';
    echo '<ul' . $ulClassAttr . '>';
    foreach ($menu as $menuKey => $menuData) {
        $name = htmlspecialchars($menuData['name'] ?? $menuKey, ENT_QUOTES);
        $path = htmlspecialchars($menuData['path'] ?? '#', ENT_QUOTES);
        echo "<li><a href=\"{$path}\">{$name}</a></li>";
    }
    echo '</ul>';
}

/**
 * Načíta datas.json a podľa názvu aktuálnej stránky vloží príslušné CSS linky.
 *
 * Očakáva súbor: data/datas.json
 *
 * @return void
 */
function getCSS(): void {
    $jsonFile = __DIR__ . '/data/datas.json';
    if (!file_exists($jsonFile)) {
        return;
    }

    $jsonStr = file_get_contents($jsonFile);
    if ($jsonStr === false) {
        return;
    }

    $data = json_decode($jsonStr, true);
    if (!is_array($data) || !isset($data['stranky'])) {
        return;
    }

    // Získa názov súboru z REQUEST_URI, napr. /portfolio.php -> portfolio
    $requestUri = $_SERVER['REQUEST_URI'] ?? '';
    $stranka = basename($requestUri);
    $stranka = explode('.', $stranka)[0];

    if (!isset($data['stranky'][$stranka]) || !is_array($data['stranky'][$stranka])) {
        return;
    }

    $suboryCSS = $data['stranky'][$stranka];
    foreach ($suboryCSS as $subor) {
        $href = htmlspecialchars($subor, ENT_QUOTES);
        echo "<link rel=\"stylesheet\" href=\"{$href}\">" . PHP_EOL;
    }
}

/**
 * Pripraví pole portfólia s číslovaním položiek.
 *
 * @param int $numberOfRows
 * @param int $numberOfCols
 * @return array
 */
function preparePortfolio(int $numberOfRows = 2, int $numberOfCols = 4): array {
    $portfolio = [];
    $colIndex = 1;

    for ($i = 1; $i <= $numberOfRows; $i++) {
        for ($j = 1; $j <= $numberOfCols; $j++) {
            $portfolio[$i][$j] = $colIndex;
            $colIndex++;
        }
    }

    return $portfolio;
}

/**
 * Vypíše HTML pre portfólio (používa preparePortfolio()).
 *
 * @param int $rows
 * @param int $cols
 * @return void
 */
function finishPortfolio(int $rows = 2, int $cols = 4): void {
    $portfolio = preparePortfolio($rows, $cols);

    foreach ($portfolio as $row => $colsArr) {
        echo '<div class="row">' . PHP_EOL;
        foreach ($colsArr as $index) {
            $id = 'portfolio-' . intval($index);
            $text = 'Web stránka ' . intval($index);
            echo '<div class="col-25 portfolio text-white text-center" id="' . htmlspecialchars($id, ENT_QUOTES) . '">';
            echo htmlspecialchars($text, ENT_QUOTES);
            echo '</div>' . PHP_EOL;
        }
        echo '</div>' . PHP_EOL;
    }
}

/**
 * Načíta banner dáta z JSON súboru.
 *
 * Očakávaná štruktúra v data/datas.json:
 * {
 *   "text_banner": {
 *     "banner1.jpg": "Prvý nadpis",
 *     "banner2.jpg": {"text":"Druhý nadpis", "url": "/page2.php"},
 *     "banner3.jpg": {"text":"Tretí nadpis", "url": null}
 *   }
 * }
 *
 * @param string $jsonPath cesta k JSON súboru
 * @return array
 */
function loadBannerData(string $jsonPath = __DIR__ . '/data/datas.json'): array {
    if (!file_exists($jsonPath)) {
        return [];
    }

    $jsonStr = file_get_contents($jsonPath);
    if ($jsonStr === false) {
        return [];
    }

    $data = json_decode($jsonStr, true);
    if (!is_array($data)) {
        return [];
    }

    return $data['text_banner'] ?? [];
}

/**
 * Vygeneruje HTML pre bannery/slajdy na základe dát z JSON.
 *
 * @param array $banners asociatívne pole z loadBannerData()
 * @param string $imgBasePath cesta (relatívna) k priečinku s obrázkami, napr. "img/banner/"
 * @param string $containerClass voliteľná trieda pre obalový element
 * @return void
 */
function generateSlides(array $banners, string $imgBasePath = 'img/banner/', string $containerClass = 'slider'): void {
    if (empty($banners)) {
        return;
    }

    // Obal
    echo '<div class="' . htmlspecialchars($containerClass, ENT_QUOTES) . '">' . PHP_EOL;

    foreach ($banners as $filename => $meta) {
        // Podpora dvoch možných foriem v JSON: buď "banner1.jpg":"Text" alebo "banner1.jpg": {"text":"Text","url":"/..."}
        $text = '';
        $url = null;

        if (is_array($meta)) {
            $text = (string)($meta['text'] ?? '');
            $url = isset($meta['url']) ? (string)$meta['url'] : null;
        } else {
            $text = (string)$meta;
        }

        $imgSrc = rtrim($imgBasePath, '/') . '/' . ltrim($filename, '/');
        $imgEsc = htmlspecialchars($imgSrc, ENT_QUOTES);
        $textEsc = htmlspecialchars($text, ENT_QUOTES);

        // Ak je definované URL, obalíme obrázok odkazom
        if (!empty($url)) {
            $urlEsc = htmlspecialchars($url, ENT_QUOTES);
            echo '  <div class="slide">' . PHP_EOL;
            echo '    <a href="' . $urlEsc . '">' . PHP_EOL;
            echo '      <img src="' . $imgEsc . '" alt="' . $textEsc . '">' . PHP_EOL;
            echo '      <div class="slide-caption">' . $textEsc . '</div>' . PHP_EOL;
            echo '    </a>' . PHP_EOL;
            echo '  </div>' . PHP_EOL;
        } else {
            echo '  <div class="slide">' . PHP_EOL;
            echo '    <img src="' . $imgEsc . '" alt="' . $textEsc . '">' . PHP_EOL;
            echo '    <div class="slide-caption">' . $textEsc . '</div>' . PHP_EOL;
            echo '  </div>' . PHP_EOL;
        }
    }

    echo '</div>' . PHP_EOL;
}