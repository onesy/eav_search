<?php
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 3:46 PM
 */

namespace eavSearch\EavSearch;

/**
 * 将行转变成列存储之后
 * 所有的条件都可以简单的进行索引，最重要的，不同的查询条件，可以进行集合操作了！
 *
 * Class Searcher
 * @package eavSearch\EavSearch
 */
class Searcher
{
    const EQUAL = "eq";

    protected $table;

    protected $searchEngine;

    protected $search_id = "search_id";

    protected $search_cond = [];

    public function getTableName()
    {
        return $this->table;
    }

    public function getSearchEngine():SearchEngine
    {
        return $this->searchEngine;
    }

    public function getSearchIdName()
    {
        return $this->search_id;
    }

    public function getSearchCond()
    {
        return $this->search_cond;
    }

    public function __construct($table, SearchEngine $searchEngine)
    {
        $this->searchEngine = $searchEngine;
        $this->table = getenv("prefix") . $table;
        return $this;
    }

    public function where(string $tag, string $value, string $op = 'eq'):Searcher
    {
        $this->search_cond[] = [
            'tag' => $tag,
            'value' => $value,
            'op' => $op,
        ];
        return $this;
    }

    public function setSearchId(string $search_id)
    {
        $this->search_id = $search_id;
    }

    public function query(bool $debug = false):array
    {
        $queryer = new Queryer($this);
        return $queryer->fetch($debug);
    }

}