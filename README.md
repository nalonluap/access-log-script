# access-log-script
### for start
```php script.php access_log```

На всё потребовалось 4 часа 10 минут

Access Log Script for php develop test

Имеется обычный http access_log файл.
Требуется написать PHP скрипт, обрабатывающий этот лог и выдающий информацию о нём в json виде.
Требуемые данные: количество хитов/просмотров, количество уникальных url, объем трафика, количество строк всего, количество запросов от поисковиков, коды ответов. Пример лог файла и ожидаемый вывод

# Требование
Код может быть любым, начиная от простого plain text скрипта, до продуманной архитектуры standalone приложения.
Главное требование — он должен быть production ready. То есть легко читаться сторонним разработчиком, легко поддерживаться при каких-либо изменениях к требованиям в будущем и аккуратно оформлен. Представьте, что вы делаете Pull Request для реальной задачи.  
Также код должен справляться с большим объемом записей. Представьте, что ему будет скормлен лог файл на 1 млрд. строк.


# Input
```
84.242.208.111 - - [11/May/2013:06:31:00 +0200] "POST /chat.php HTTP/1.1" 200 354 "http://bim-bom.ru/" "Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0"
91.224.96.130 - - [11/May/2013:04:09:02 -0700] "GET /mod.php HTTP/1.0" 301 12413 "http://wiki.org/index.php#lang=en" "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)"
77.21.132.156 - - [24/May/2013:23:37:48 +0200] "POST /app/engine/api.php HTTP/1.1" 200 80 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:37:48 +0200] "POST /app/modules/randomgallery.php HTTP/1.1" 200 46542 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:37:50 +0200] "POST /chat.php?id=a65 HTTP/1.1" 200 366 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:03 +0200] "POST /app/engine/api.php HTTP/1.1" 200 80 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) Googlebot/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:05 +0200] "POST /chat.php?id=a65 HTTP/1.1" 200 31 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:23 +0200] "POST /app/modules/randomgallery.php HTTP/1.1" 200 46542 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
84.242.208.111 - - [11/May/2013:06:31:00 +0200] "POST /chat.php HTTP/1.1" 200 354 "http://bim-bom.ru/" "Mozilla/5.0 (Windows NT 6.1; rv:20.0) Gecko/20100101 Firefox/20.0"
91.234.91.31 - - [11/May/2013:04:09:02 -0700] "GET /mod.php HTTP/1.0" 301 12413 "http://wiki.org/index.php#lang=en" "Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; WOW64; Trident/5.0)"
77.21.132.156 - - [24/May/2013:23:37:48 +0200] "POST /app/engine/api.php HTTP/1.1" 200 80 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:37:48 +0200] "POST /app/modules/randomgallery.php HTTP/1.1" 200 46542 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:37:50 +0200] "POST /chat.php?id=a65 HTTP/1.1" 200 366 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:03 +0200] "POST /app/engine/api.php HTTP/1.1" 200 80 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) Googlebot/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:05 +0200] "POST /chat.php?id=a65 HTTP/1.1" 200 31 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
77.21.132.156 - - [24/May/2013:23:38:23 +0200] "POST /app/modules/randomgallery.php HTTP/1.1" 200 46542 "http://lag.ru/index.php" "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31"
```
# Output
```
{
  views: 16,
  urls: 5,
  traffic: 212816,
  crawlers: {
      Google: 2,
      Bing: 0,
      Baidu: 0,
      Yandex: 0
  },
  statusCodes: {
      200 : 14,
      301 : 2
  }
}
```
