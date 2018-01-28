<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 0.13
 */

namespace Radioactive;

use Monolog\Logger;

class Application
{
    /**
     * @var Logger
     */
    protected $_logger;
    protected $_radioWorker;

    public function __construct(Logger $logger, RadioWorker $radioWorker)
    {
        $this->_logger = $logger;
        $this->_radioWorker = $radioWorker;
    }

    public function start()
    {
        $this->_logger->info('Radioactive has been started!');
        $this->_radioWorker->start();
        $this->_logger->info('Radioactive has been stopped!');
    }
}