<?php
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 3:08 PM
 */

namespace eavSearch\Entities;


trait EntityTrait
{
    protected $obj;

    protected $id;

    protected $eavs;

    public function addEav(string $tag, string $value, int $search_id)
    {
        $this->eavs[] = [
            'tag' => $tag,
            'value' => $value,
            'search_id' => $search_id,
        ];
    }

    public function getEavs()
    {
        return $this->eavs;
    }

    public function setId(string $id)
    {
        $this->id = $id;
    }

    public function getId():string
    {
        return $this->id;
    }
}