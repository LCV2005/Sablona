<?php

declare(strict_types=1);

class QnA
{
    private PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        if ($pdo !== null) {
            $this->pdo = $pdo;
            return;
        }

        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3306';
        $dbName = getenv('DB_NAME') ?: 'sablona';
        $username = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASS') ?: '';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbName);

        $this->pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    /**
     * Nacita vsetky otazky a odpovede z databazovej tabulky qna.
     *
     * Ocakavane stlpce: question, answer
     */
    public function getQuestionsAndAnswers(): array
    {
        $sql = 'SELECT question, answer FROM qna ORDER BY id ASC';
        $stmt = $this->pdo->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Vlozi ukazkove data do tabulky qna.
     *
     * Tip: metodu (alebo jej volanie) nechajte zakomentovanu,
     * aby sa data nevkladali opakovane pri kazdom nacitani stranky.
     */
    public function insertSampleQuestionsAndAnswers(): void
    {
        $sql = 'INSERT INTO qna (question, answer) VALUES (:question, :answer)';
        $stmt = $this->pdo->prepare($sql);

        $sampleData = [
            [
                'question' => 'Ake su vase skusenosti s PHP?',
                'answer' => 'Mam zakladne znalosti PHP a rad sa v nom zlepsujem.',
            ],
            [
                'question' => 'Aky je vas oblubeny programovaci jazyk?',
                'answer' => 'Najradsej pracujem s PHP.',
            ],
            [
                'question' => 'Ake je najlepsie zviera?',
                'answer' => 'Odpoved bude vzdy kacica.',
            ],
        ];

        foreach ($sampleData as $item) {
            $stmt->execute($item);
        }
    }
}
