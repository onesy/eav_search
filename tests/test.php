<?php
include dirname(__DIR__) . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "autoload.php";
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 1:48 PM
 */
$search_engine = new \eavSearch\EavSearch\SearchEngine("../config/");
//$i = 4000;
//$testuser = new \eavSearch\Test\TestTool();
//$testuser->generateRandomUser(2,$i);
//foreach($testuser->user as $value) {
//    $search_engine->addEntity($value);
//}
$sqls = $search_engine->name("column_search")
    ->where("name","%f%", "like")
    ->where("id", "2","egt")
    ->where("age","79","egt")
    ->where("color", "25", "egt")
    ->query();
var_dump($sqls);die;