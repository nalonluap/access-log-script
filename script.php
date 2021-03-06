<?php

require_once 'AccessLogParser.php';

try {
    if (!isset($argv[1])) {
        throw new Exception('Имя файла не указано');
    }

    $fileName = $argv[1];
    if (!file_exists($fileName)) {
        throw new Exception("Файл \"$fileName\" не найден");
    }

    $accessLogParser = new AccessLogParser($fileName);
    echo $accessLogParser->getLines();
    echo json_encode($accessLogParser->parseAllFile()) . PHP_EOL;
    echo "Lines: {$accessLogParser->getLines()}";
} catch (Exception $exception) {
    echo "Ошибка! {$exception->getMessage()}" . PHP_EOL;
}
