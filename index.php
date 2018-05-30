<?php

$animalsFileName = 'animals.json';
$continentsArray = getDataFromJSON($animalsFileName);

$splitedContinents = [
    'source' => [],
    'data' => [],
];

foreach ($continentsArray as $continent => $animalsArray) {
    $splitedContinents['source'][$continent] = [];

    foreach ($animalsArray as $animal) {
        $moreThanOneWord = substr_count($animal, ' ');

        if ($moreThanOneWord) {
            list($firstWord, $secondWord) = explode(' ', $animal);
            
            $splitedContinents['source'][$continent][] = $firstWord;
            $splitedContinents['data'][] = $secondWord;
        }
    }
}

shuffle($splitedContinents['data']);

foreach ($splitedContinents['source'] as $continent => $firstWordsArray) {
    echo '<h2>', $continent, '</h2>';
    $result = [];

    foreach ($firstWordsArray as $firstWord) {
      if (count($splitedContinents['data'])) {
        $result[] = $firstWord . ' ' . array_pop($splitedContinents['data']);
      }
    }

    echo '<p>', implode(', ', $result), '</p>';
}

function getDataFromJSON($fileName) {
    if (!is_file($fileName)) {
        exit("$fileName is not a file");

    } elseif (!is_readable($fileName)) {
        exit("Have no access to read $fileName");
    }

    $dataJSON = file_get_contents($fileName);
    return ((array) json_decode($dataJSON));
}
