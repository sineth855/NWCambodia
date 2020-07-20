<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/NWCambodia_New/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/NWCambodia_New/');

// DIR
define('DIR_APPLICATION', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia_New/catalog/');
define('DIR_SYSTEM', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia_New/system/');
define('DIR_IMAGE', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia_New/image/');
define('DIR_STORAGE', 'F:/SIMLONGDYWORK/wamp64/www/NWCambodia_New/storage/');
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
define('DB_DATABASE', 'lyhout_db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'nw_');