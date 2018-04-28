<?php
namespace eavSearch\Entities;
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/26/18
 * Time: 7:38 PM
 */
class ColumnSearch {

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $value;

    /**
     * @var int
     */
    private $search_id;

    public function getId()
    {
        return $this->id;
    }

    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    public function getTag()
    {
        return $this->tag;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setSearchId(int $search_id)
    {
        $this->search_id = $search_id;
    }

    public function getSearchId()
    {
        return $this->search_id;
    }
}