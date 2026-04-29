<?php

declare(strict_types=1);

namespace App\Classes;

class QnA extends Database
{
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
