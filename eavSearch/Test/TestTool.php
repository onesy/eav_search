<?php
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 4:30 PM
 */

namespace eavSearch\Test;


use Rych\Random\Random;

class TestTool
{
    public $user;

    public function generateRandomUser(int $start_id, int $length = 400)
    {
        for($i = $start_id; $i <= $start_id + $length; $i ++) {
            $user = [];
            $tags = $this->getRandomTags($i);
            foreach($tags as $tag) {
                $user[$tag['tag']] = $tag['callback']();
            }
            $this->user[] = $user;
        }
    }

    public function getRandomName(): string
    {
        $random = new Random();
        return $random->getRandomString(rand(5,20), "utf8");
    }

    public function getRandomAge(): int
    {
        return rand(18, 100);
    }

    public function getRandomColor(): int
    {
        return rand(0,65535);
    }

    public function getRandomProvince(): string
    {
        $random = new Random();
        return $random->getRandomString(rand(5,20), "utf8");
    }

    public function getRandomCity(): string
    {
        $random = new Random();
        return $random->getRandomString(rand(5,20), "utf8");
    }

    public function getRandomGender(): int
    {
        return rand(0,1);
    }

    public function getRandomPrice(): float
    {
        $random = new Random();
        $a = $random->getRandomInteger(200,20000);
        $b = $random->getRandomInteger(1,5);
        return $a / $b;
    }

    public function getRandomDay(): int
    {
        return rand(10,1000);
    }

    public function getRandomTags(int $id):array
    {
        $meta = [
            0 => ['tag' => 'id', "callback" => function()use($id){
            return $id;
            }],
            1 => ['tag' => 'age', "callback" => function(){
            return $this->getRandomAge();
            }],
            2 => ['tag' => 'name', "callback" => function(){
            return $this->getRandomName();
            }],
            3 => ['tag' => 'color', "callback" => function(){
            return $this->getRandomColor();
            }],
            4 => ['tag' => 'province', "callback" => function(){
            return $this->getRandomProvince();
            }],
            5 => ['tag' => 'city', "callback" => function(){
            return $this->getRandomCity();
            }],
            6 => ['tag' => 'sex', "callback" => function(){
            return $this->getRandomGender();
            }],
            7 => ['tag' => 'day', "callback" => function(){
            return $this->getRandomDay();
            }],
            8 => ['tag'=> 'price', "callback" => function(){
            return $this->getRandomPrice();
            }],
        ];
        unset($meta[random_int(1,8)]);
        return $meta;
    }
}