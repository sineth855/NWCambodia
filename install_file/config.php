<?php
// HTTP
define('HTTP_SERVER', 'http://nutritionwarehouse.local:8080/');

// HTTPS
define('HTTPS_SERVER', 'http://nutritionwarehouse.local:8080/');

// DIR
define('DIR_APPLICATION', 'D:/SIM SINETH/Project/Web/personal/NutritionWhareHouse/development/upload/catalog/');
define('DIR_SYSTEM', 'D:/SIM SINETH/Project/Web/personal/NutritionWhareHouse/development/upload/system/');
define('DIR_IMAGE', 'D:/SIM SINETH/Project/Web/personal/NutritionWhareHouse/development/upload/image/');
define('DIR_STORAGE', 'D:/SIM SINETH/Project/Web/personal/NutritionWhareHouse/development/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'cache/');
define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
define('DIR_LOGS', DIR_STORAGE . 'logs/');
define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
define('DIR_SESSION', DIR_STORAGE . 'session/');
define('DIR_UPLOAD', DIR_STORAGE . 'upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'nutrition_warehouse');
define('DB_PORT', '3306');
define('DB_PREFIX', 'nw_');