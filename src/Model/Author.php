<?php
/**
 * Created by PhpStorm.
 * User: leequix
 * Date: 28.1.18
 * Time: 14.19
 */

namespace Radioactive\Model;


class Author
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $foundationDate;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFoundationDate(): string
    {
        return $this->foundationDate;
    }

    /**
     * @param string $foundationDate
     */
    public function setFoundationDate(string $foundationDate)
    {
        $this->foundationDate = $foundationDate;
    }
}