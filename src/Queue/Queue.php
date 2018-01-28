<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 0.26
 */

namespace Radioactive\Queue;


interface Queue
{
    /**
     * @return int
     */
    public function getNext();
}