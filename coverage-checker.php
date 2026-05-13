<?php

$inputFile = $argv[1];
$percentage = min(100, (float) $argv[2]);

if (! file_exists($inputFile)) {
    throw new InvalidArgumentException('Invalid input file provided');
}

$xml = new SimpleXMLElement(file_get_contents($inputFile));
$metrics = $xml->xpath('//metrics');
$totalElements = 0;
$checkedElements = 0;

foreach ($metrics as $metric) {
    $totalElements += (int) $metric['elements'];
    $checkedElements += (int) $metric['coveredelements'];
}

$coverage = ($checkedElements / $totalElements) * 100;

if ($coverage < $percentage) {
    echo "Code coverage is {$coverage}%, which is below the accepted {$percentage}%".PHP_EOL;
    exit(1);
}

echo "Code coverage is {$coverage}% - OK!".PHP_EOL;
