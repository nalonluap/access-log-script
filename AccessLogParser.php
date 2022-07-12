<?php

//Требуемые данные: количество хитов/просмотров, количество уникальных url,
//объем трафика, количество строк всего, количество запросов от поисковиков, коды ответов

class AccessLogParser {

    private $pathToFile;
    private $urls_arr = [];
    private $lines;
    private $result = [
        'views' => 0,
        'urls' => 0,
        'traffic' => 0,
        'crawlers' => [
            'Google' => 0,
            'Yandex' => 0,
            'Bing' => 0,
            'Baidu' => 0,
            'Rambler' =>0,
        ],
        'statusCodes' => [],
    ];

    function __construct($logPath)
    {
        $this->pathToFile = $logPath;
    }

    public function parseAllFile(){
        $file = fopen($this->pathToFile,'r') or die ('Не удаётся открыть указанный файл');
        while (!feof($file)) {
            $logString = trim(fgets($file));//Вывод по строке данных из лог файла
            $this->parseLogFileString($logString);
        }
        fclose($file);
        return $this->result;
    }

    private function parseLogFileString($stringLog){

        $pattern = "/(\S+)(\s+-|\S) (\S+|-) \[([^:]+):(\d+:\d+:\d+) ([^\]]+)\] \"(\S+) (?<url>.*?) (\S+)\" (?<statusCode>\d+|\d+ - \d+) (?<traffic>\d+) \"(.*?)\" \"(.*?((\) (?<crawler>.*?)\/)|((.*?;){4}) (.*?)\/).*?)\"/";
        preg_match($pattern, $stringLog, $stringLogResult);
        $this->lines++;

        $url = $stringLogResult['url']; //url web страницы
        $statusCode = $stringLogResult['statusCode']; // Получение кода статуса
        $traffic = $stringLogResult['traffic']; // Получение трафика
        $crawler = $stringLogResult['crawler']; //Данные о поисковиках

        $this->result['traffic'] += $traffic;

        if ($crawler == '') {
            $crawler = $stringLogResult[19];//Поисковик для 301 статуса
        }

        if (!empty($url)){
            $this->result['views']++;
        }

        foreach ($this->result['crawlers'] as $key => $value) {
            if(preg_match('/^' . $key . '(.*?)/i',$crawler)) //Увеличим значение, если в строке найдется совпадение по одному из ключей массива поисковиков
                $this->result['crawlers'][$key]++;
        }

        if (!in_array($url,$this->urls_arr)) {//Если нет текущего адреса в массиве уникальных адресов
            $this->result['urls']++;
            $this->urls_arr[] = $url;
        }

        if (!empty($statusCode)) {
            $this->result['statusCodes'][$statusCode]++;
        }
    }
}
