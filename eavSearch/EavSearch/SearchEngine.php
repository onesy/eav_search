<?php
namespace eavSearch\EavSearch;
use DI\Container;
use Dotenv\Dotenv;
use eavSearch\Entities\ArrayEntity;
use Medoo\Medoo;

/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 11:24 AM
 */
class SearchEngine
{
    const TABLE_NAME = "column_search";

    protected $db;

    public function __construct($env_path)
    {
        $env = new Dotenv($env_path);
        $env->load();
        $config = [
            'database_type' => getenv("database_type"),
            'database_name' => getenv("database"),
            'prefix' => getenv("prefix"),
            'server' => getenv("address"),
            'username' => getenv("user"),
            'password' => getenv("password"),
            'charset' => 'utf8'
        ];
        $this->db = new Medoo($config);
    }

    public function addEntity($object, $id = "id"):int {

        if (is_array($object)) {
            $eav = new ArrayEntity($object, $id);
            $eav->analyze();
        } else {
            // 反射出所有属性
        }
        $this->db->pdo->beginTransaction();
        $pdostatement = $this->db->insert(self::TABLE_NAME, $eav->getEavs());
//        var_dump($this->db->error());
        $this->db->pdo->commit();
        return $pdostatement->rowCount();
    }

    public function name($table){
        return new Searcher($table, $this);
    }

    public function getDb():Medoo
    {
        return $this->db;
    }
}