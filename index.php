<?php

$animalsFileName = 'animals.json';
$animalsArray = getDataFromJSON($animalsFileName);

$twoWordNamesAnimals = filterByWordsCount($animalsArray, 2);
$splitedData = splitArrayWithSaveSources($twoWordNamesAnimals);
$splicedData = spliceDataWithSaveSources($splitedData);


foreach ($splicedData as $continent => $animalsArrayByContinent) {
    echo '<h2>', $continent, '</h2>';
    echo '<p>', implode(', ', $animalsArrayByContinent), '</p>';
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


function filterByWordsCount($dataArray, $wordsCount = 1) {
    if (gettype($dataArray) !== 'array') {
        throw new Error('$dataArray is not array');
    }

    $result = [];

    foreach ($dataArray as $dataKey => $innerArray) {

        if (gettype($innerArray) !== 'array') {
            break;
        }

        $filteredInnerArray = [];

        foreach ($innerArray as $innerKey => $innerData) {

            if (gettype($innerData) !== 'string') {
                break;
            }

            $explodedData = explode(' ', $innerData);

            if (count($explodedData) === $wordsCount) {
                $filteredInnerArray[] = $innerData;
            }
        }

        $result[$dataKey] = $filteredInnerArray;
    }

    return $result;
}


function splitArrayWithSaveSources($dataArray) {
    if (gettype($dataArray) !== 'array') {
        throw new Error('$dataArray is not array');
    }

    $result = [
        'source' => [],
        'data' => [],
    ];

    foreach ($dataArray as $key => $valuesArray) {

        $firstWords = [];

        foreach ($valuesArray as $valueString) {

            list($firstWord, $secondWord) = explode(' ', $valueString);
            $firstWords[] = $firstWord;
            $result['data'][] = $secondWord;
        }

        $result['source'][$key] = $firstWords;
    }

    return $result;
}


function spliceDataWithSaveSources($dataArray) {
    if (gettype($dataArray) !== 'array') {
        throw new Error('$dataArray is not array');

    } elseif (gettype($dataArray['source']) !== 'array') {
        throw new Error('$dataArray[\'source\'] is not array');

    } elseif (gettype($dataArray['data']) !== 'array') {
        throw new Error('$dataArray[\'data\'] is not array');
    }

    $result = [];

    $sources = $dataArray['source'];
    $data = $dataArray['data'];
    shuffle($data);

    $iterationCounter = 0;

    foreach ($sources as $key => $valuesArray) {

        $splicedWords = [];

        foreach ($valuesArray as $firstWord) {

            $secondWord = $data[$iterationCounter];
            $splicedWords[] = implode(' ', [$firstWord, $secondWord]);
            $iterationCounter++;
        }

        $result[$key] = $splicedWords;
    }

    return $result;
}
