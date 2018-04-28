<?php
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 5:21 PM
 */

namespace eavSearch\EavSearch;

/**
 * EAV Query 构造器
 * Class Queryer
 * @package eavSearch\EavSearch
 */
class Queryer
{
    public $tmp_sql = "";

    protected $ids = [];

    protected $searcher;

    protected $build_sqls;

    protected $querys;

    protected $db;

    public function __construct(Searcher $searcher)
    {
        $this->searcher = $searcher;
        $this->db = $searcher->getSearchEngine()->getDb();
    }

    protected function subParts(array $conds, array $ids)
    {
        $i = 0;
        $sqls = [];
        foreach($conds as &$con) {
            $con['tag'] = $this->db->quote($con['tag']);
            $con['value'] = $this->db->quote($con['value']);
        }
        if ($ids) {
            $in_id = " and search_id in (" . implode(",", $ids) . ")";
        } else {
            $in_id = "";
        }
        // 一组
        foreach($conds as $cond) {
            // 每一个条件构成一个子查询
            $op = $this->getOp($cond['op']);
            $sql['sql'] = "(select {$this->searcher->getSearchIdName()} as id
from {$this->searcher->getTableName()} where `tag` = {$cond['tag']} and
 `value` {$op} {$cond['value']} {$in_id}) as sub{$i}";
            $sql['alia'] = "sub{$i}";
            $i ++;
            $sqls[] = $sql;
        }

        $join_sql = "";
        for ($i = 0; $i < count($sqls); $i ++) {
            if ($i == 0) {
                $join_sql = $sqls[$i]['sql'];
                continue;
            }
            $front_table_name = $sqls[$i - 1]['alia'];
            $after_table_name = $sqls[$i]['alia'];
            $join_sql .= " inner join {$sqls[$i]['sql']} on {$front_table_name}.id = {$after_table_name}.id ";
        }

        $tpl = "select `sub0`.`id` from {$join_sql}";
        return $tpl;
    }

    protected function getOp(string $op):string
    {
        switch ($op)
        {
            case 'eq':
                return "=";
            case "like":
                return "like";
            case "elt":
                return "<=";
            case "egt":
                return ">=";
            case "nq":
                return "<>";
            default:
                return "=";
        }
    }

    public function fetch(bool $debug = false)
    {
        $chunked_search_cond = array_chunk($this->searcher->getSearchCond(), 3);
        foreach($chunked_search_cond as $value) {
            $sql = $this->subParts($value, $this->ids);
            if ($debug) {
                $this->build_sqls[] = $sql;
                continue;
            }
            $cursor = $this->searcher->getSearchEngine()->getDb()->query($sql)->fetchAll();
            $ids = array_column($cursor, "id");
            asort($ids);

            $this->ids = empty($this->ids) ? array_merge($this->ids, $ids): array_intersect($this->ids, $ids);
//            var_dump(empty($this->ids));
        }
        if ($debug) {
            return $this->build_sqls;
        }
        return $this->ids;
    }
}