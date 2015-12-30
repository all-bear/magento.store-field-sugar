<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Data\Model;

class Test extends \AllBear\StoreFieldSugar\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AllBear\StoreFieldSugar\Test\Data\Model\ResourceModel\Test');
    }
}