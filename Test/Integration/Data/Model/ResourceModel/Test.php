<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Data\Model\ResourceModel;

class Test extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('all_bear_test_unit_data_test', 'entity_id');
    }
}