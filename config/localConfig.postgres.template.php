<?php

/* Oauth 1.0 Settings (For use when installing the app in Canvas) */
$consumer_key = getenv('CONSUMER_KEY');
$shared_secret = getenv('SHARED_SECRET');

/* Oauth 2.0 Settings (Provided by Instructure) */
$oauth2_id        = getenv('OAUTH2_ID');
$oauth2_key       = getenv('OAUTH2_KEY');
$oauth2_uri       = getenv('OAUTH2_URI');

/* Disable headings check character count */
$doc_length = 1500;

/* Tool name for display in Canvas Navigation */
$canvas_nav_item_name = getenv('CANVAS_NAV_ITEM_NAME');

/* File Scan Size Limit */
$file_scan_size_limit = getenv('SCAN_FILE_SIZE_LIMIT') ?: 52428800;

/* Alt Text Length Limit */
$alt_text_length_limit = getenv('ALT_TEXT_LENGTH_LIMIT') ?: 125;

/* Google/YouTube Data Api Key */
define('GOOGLE_API_KEY', 'TEST_API_KEY');

/* Google Analytics Tracking Code */
define('GA_TRACKING_CODE', getenv('GOOGLE_API_KEY')?:'');

/* Vimeo API Key */
define('VIMEO_API_KEY', getenv('VIMEO_API_KEY')?:'');

/* Database Config */
$db_type          = 'pgsql';
$db_host          = getenv('DATABASE_HOST');
$db_port          = getenv('DATABASE_PORT');
$db_user          = getenv('DATABASE_USER');
$db_password      = getenv('DATABASE_PWD');
$db_name          = getenv('DATABASE_NAME');
$db_user_table    = 'users';
$db_reports_table = 'reports';
$dsn = "pgsql:host={$db_host};port={$db_port};dbname={$db_name};user={$db_user};password={$db_password};sslmode=require";

$debug = false;

// added in v2.3.0
// Background worker Options (See Background Workers in Readme)
$background_worker_enabled = false;
$background_job_expire_time = 20; // after x Minutes, mark job as expired
$background_worker_sleep_seconds = 1;

// Sets CURLOPT_SSL_VERIFYPEER and CURLOPT_SSL_VERIFYHOST
// This should be true for production environments
$curl_ssl_verify = true;

// send logs into the phpunit output
$log_handler = new \Monolog\Handler\TestHandler(null, \Monolog\Logger::WARNING);
$log_handler->setFormatter(new \Monolog\Formatter\LineFormatter(null, null, true, true));
