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
        list($firstWord, $secondWord) = explode(' ', $animal);

        if ($secondWord) {
            $splitedContinents['source'][$continent][] = $firstWord;
            $splitedContinents['data'][] = $secondWord;
        }
    }
}

shuffle($splitedContinents['data']);
$i = 0;

foreach ($splitedContinents['source'] as $continent => $firstWordsArray) {
    echo '<h2>', $continent, '</h2>';
    $result = [];

    foreach ($firstWordsArray as $firstWord) {
      $result[] = $firstWord . ' ' . $splitedContinents['data'][$i++];
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
