<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 27.1.18
 * Time: 23.37
 */

use Monolog\Logger;
use Dotenv\Dotenv;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = new Dotenv(__DIR__);
    $dotenv->load();
}

function stringLogLevelToInt(string $level)
{
    switch (strtolower($level)) {
        case 'debug':
            return Logger::DEBUG;
        case 'info':
            return Logger::INFO;
        case 'warning':
            return Logger::WARNING;
        case 'error':
            return Logger::ERROR;
        case 'critical':
            return Logger::CRITICAL;
        default:
            return Logger::EMERGENCY;
    }
}

function env(string $key, $default): string
{
    if ($_ENV[$key]) {
        return $_ENV[$key];
    }
    return $default;
}

$config = [
    'log.file' => env('LOG_FILE', 'php://stdout'),
    'log.level' => stringLogLevelToInt(env('LOG_LEVEL', Logger::INFO)),

    'icecast.host' => env('ICECAST_HOST', 'localhost'),
    'icecast.port' => env('ICECAST_PORT', 8000),

    'icecast.mountpoint.name' => env('ICECAST_MOUNTPOINT_NAME', '/live'),
    'icecast.mountpoint.username' => env('ICECAST_MOUNTPOINT_USERNAME', 'source'),
    'icecast.mountpoint.password' => env('ICECAST_MOUNTPOINT_PASSWORD', 'hackme'),

    'icecast.stream.name' => env('ICECAST_STREAM_NAME', 'Stream'),
    'icecast.stream.description' => env('ICECAST_STREAM_DESCRIPTION', 'Nonstop music'),
    'icecast.stream.genre' => env('ICECAST_STREAM_DESCRIPTION', 'Music'),
    'icecast.stream.bitrate' => env('ICECAST_STREAM_BITRATE', 192000),
    'icecast.stream.content-type' => env('ICECAST_STREAM_CONTENT_TYPE', 'audio/mpeg'),
    'icecast.stream.url' => env('ICECAST_STREAM_URL', 'http://localhost'),

    'mysql.host' => env('MYSQL_HOST', 'localhost'),
    'mysql.port' => env('MYSQL_PORT', 3306),
    'mysql.dbname' => env('MYSQL_DATABASE', 'radioactive'),
    'mysql.username' => env('MYSQL_USERNAME', 'root'),
    'mysql.password' => env('MYSQL_PASSWORD', ''),

    'redis.host' => env('REDIS_HOST', 'localhost'),
    'redis.port' => env('REDIS_PORT', 6379)
];

return $config;