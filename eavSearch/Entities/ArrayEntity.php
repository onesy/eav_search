<?php
/**
 * Created by PhpStorm.
 * User: sunyuw
 * Date: 4/27/18
 * Time: 3:03 PM
 */

namespace eavSearch\Entities;


class ArrayEntity implements EntityInterface
{

    use EntityTrait;

    public function __construct($object, $id)
    {
        $this->obj = $object;
        $this->id = $id;
    }

    public function analyze()
    {
        // TODO: Implement analyze() method.
        if (!is_array($this->obj)) {
            throw new \InvalidArgumentException("只能处理数组类型");
        }
        $id = $this->obj[$this->id];
        foreach($this->obj as $key => $value) {
            $this->addEav($key, $value, $id);
        }
    }

}