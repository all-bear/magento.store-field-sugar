<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Data\Model;

use Magento\Framework\DB\Ddl\Table;

class Test extends \AllBear\StoreFieldSugar\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('AllBear\StoreFieldSugar\Test\Data\Model\ResourceModel\Test');

        $this->_initStoreField('test_string', Table::TYPE_TEXT);
    }
}