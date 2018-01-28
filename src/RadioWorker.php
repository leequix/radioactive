<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 0.32
 */

namespace Radioactive;


use IcecastStreamer\Stream;
use Monolog\Logger;
use Radioactive\Queue\Queue;
use Radioactive\Repository\TrackRepository;

class RadioWorker
{
    private $_isWorking;
    private $_queue;
    private $_trackRepository;
    private $_stream;
    private $_logger;

    private $_bitrate;

    public function __construct(Queue $queue, Logger $logger, TrackRepository $trackRepository, Stream $stream, int $bitrate)
    {
        $this->_queue = $queue;
        $this->_trackRepository = $trackRepository;
        $this->_stream = $stream;
        $this->_logger = $logger;
        $this->_bitrate = $bitrate;
    }


    public function start()
    {
        $this->_isWorking = true;
        $lastTrackId = 0;
        $track = null;
        $this->_stream->start();
        while ($this->_isWorking) {
            $nextTrackId = $this->getNextId($lastTrackId);
            $track = $this->_trackRepository->get($nextTrackId);
            $lastTrackId = $nextTrackId;
            $this->_logger->info('Now plays ' . $track->getName());
            $trackChunks = str_split($track->getBody(), $this->_bitrate / 1000 * 1024 / 8);
            foreach ($trackChunks as $chunk) {
                $this->_stream->write($chunk);
                $this->_logger->debug('Send ' . strlen($chunk) . ' bytes of data');
                sleep(1);
            }
        }
        $this->_stream->stop();
    }

    private function getNextId(int $lastTrackId): int
    {
        $nextTrackId = $this->_queue->getNext();
        if (!$nextTrackId) {
            $idList = $this->_trackRepository->getIds();
            if ($lastTrackId && count($idList) > 1) {
                $idKey = array_search($lastTrackId, $idList);
                unset($idList[$idKey]);
            }
            $nextTrackId = $idList[array_rand($idList)];
        }

        return $nextTrackId;
    }
}