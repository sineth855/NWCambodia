<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/NWCambodia/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/NWCambodia/');

// DIR
define('DIR_APPLICATION', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia/catalog/');
define('DIR_SYSTEM', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia/system/');
define('DIR_IMAGE', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia/image/');
define('DIR_STORAGE', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia/storage/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/theme/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CACHE', DIR_STORAGE . 'storage/cache/');
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