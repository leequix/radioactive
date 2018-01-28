<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 27.1.18
 * Time: 23.35
 */

return [
    \Monolog\Logger::class => function (\DI\Container $c) {
        $logger = new \Monolog\Logger('Radioactive');
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($c->get('log.file'), $c->get('log.level')));

        return $logger;
    },
    \Predis\Client::class => function (\DI\Container $c) {
        return new \Predis\Client([
            'host' => $c->get('redis.host'),
            'port' => $c->get('redis.port')
        ]);
    },
    \PDO::class => function(\DI\Container $c) {
        return new \PDO('mysql:host=' . $c->get('mysql.host')
            . ';dbname=' . $c->get('mysql.dbname')
            . ';port=' . $c->get('mysql.port'),
            $c->get('mysql.username'),
            $c->get('mysql.password'));
    },
    \IcecastStreamer\Stream::class => function(DI\Container $c) {
        $mountPoint = new \IcecastStreamer\Stream\MountPoint(
            $c->get('icecast.mountpoint.name'),
            new \IcecastStreamer\Stream\AuthCredentials(
                $c->get('icecast.mountpoint.username'),
                $c->get('icecast.mountpoint.password')
            )
        );
        $connection = new \IcecastStreamer\Stream\Connection(
            $c->get('icecast.host'),
            $c->get('icecast.port'),
            $mountPoint
        );

        $info = new \IcecastStreamer\Stream\Info();
        $info->setName($c->get('icecast.stream.name'));
        $info->setBitrate($c->get('icecast.stream.bitrate'));
        $info->setContentType($c->get('icecast.stream.content-type'));
        $info->setDescription($c->get('icecast.stream.description'));
        $info->setGenre($c->get('icecast.stream.genre'));
        $info->setUrl($c->get('icecast.stream.url'));
        return new IcecastStreamer\Stream($connection, $info);
    },

    \Radioactive\Queue\Queue::class => \DI\object(\Radioactive\Queue\RedisQueue::class),
    \Radioactive\RadioWorker::class => \DI\object()
        ->constructorParameter('bitrate', DI\get('icecast.stream.bitrate'))
];