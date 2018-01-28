<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 0.27
 */

namespace Radioactive\Queue;


use Predis\Client;

class RedisQueue implements Queue
{
    private $_predis;

    public function __construct(Client $predis)
    {
        $this->_predis = $predis;
    }

    public function getNext()
    {
        return $this->_predis->rpop('tracks');
    }
}