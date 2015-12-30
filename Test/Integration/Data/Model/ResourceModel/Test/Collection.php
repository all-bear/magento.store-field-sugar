<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Data\Model\ResourceModel\Test;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('AllBear\StoreFieldSugar\Test\Data\Model\Test',
            'AllBear\StoreFieldSugar\Test\Data\Model\ResourceModel\Test');
    }
}