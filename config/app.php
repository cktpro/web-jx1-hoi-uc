<?php

define('APP_URL',  rtrim($_ENV['APP_URL'] ?? 'http://localhost', '/'));
define('APP_NAME', 'JX1 Game Portal');
define('TIMEZONE', 'Asia/Ho_Chi_Minh');

date_default_timezone_set(TIMEZONE);
