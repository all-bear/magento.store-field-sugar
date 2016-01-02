<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Model;

abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{
    const FIXTURE_STORE_ONE = 1;
    const FIXTURE_STORE_TWO = 2;

    protected $model;

    protected $objectManager;

    protected $storeManager;

    protected $storeDummy;

    protected function setUpStores()
    {
        $this->storeDummy = new \Magento\Framework\DataObject([]);

        $this->storeManager = $this->getMockBuilder('Magento\Store\Model\StoreManager')
            ->disableOriginalConstructor()->getMock();
        $this->storeManager->expects($this->any())->method('getStore')
            ->will($this->returnValue($this->storeDummy));
    }

    protected function setUp()
    {
        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->setUpStores();

        $resourceModel      =
            $this->getMockBuilder('AllBear\StoreFieldSugar\Test\Integration\Data\Model\ResourceModel\Test')
                ->disableOriginalConstructor()->getMock();
        $resourceCollection =
            $this->getMockBuilder('AllBear\StoreFieldSugar\Test\Integration\Data\Model\ResourceModel\Test\Collection')
                ->disableOriginalConstructor()->getMock();

        $this->model = new \AllBear\StoreFieldSugar\Test\Integration\Data\Model\Test(
            $this->getMockBuilder('\Magento\Framework\Model\Context')->disableOriginalConstructor()->getMock(),
            $this->getMockBuilder('\Magento\Framework\Registry')->disableOriginalConstructor()->getMock(),
            $resourceModel,
            $resourceCollection,
            $this->storeManager
        );
    }

    protected function useStore($storeId)
    {
        $this->storeDummy->setId(
            $storeId
        );
    }
}