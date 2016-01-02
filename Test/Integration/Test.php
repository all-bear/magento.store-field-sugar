<?php

namespace AllBear\StoreFieldSugar\Test\Integration;

class Test extends \PHPUnit_Framework_TestCase
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

    public function testInitialization()
    {
        $this->assertNotNull($this->model);
    }

    public function testFieldStoreValuesMagicForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setTestString('one');

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setTestString('two');

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals('one', $this->model->getTestString());

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals('two', $this->model->getTestString());
    }

    public function testFieldStoreValuesDataValueForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setData('test_string', 'one');

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setData('test_string', 'two');

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals('one', $this->model->getData('test_string'));

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals('two', $this->model->getData('test_string'));
    }

    public function testFieldStoreValuesSetDataForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setData([
            'test_string' => 'one'
        ]);

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setData([
            'test_string' => 'two'
        ]);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals('one', $this->model->getData('test_string'));

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals('two', $this->model->getData('test_string'));
    }

    public function testFieldStoreValuesSetDataCombineForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setData([
            'test_string' => 'one',
            'test'        => 'test'
        ]);

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setData([
            'test_string' => 'two',
            'test'        => 'test'
        ]);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals([
            'test_string' => 'one',
            'test'        => 'test'
        ], $this->model->getData());

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals([
            'test_string' => 'two',
            'test'        => 'test'
        ], $this->model->getData());
    }

    public function testFieldStoreValuesAddDataCombineForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);

        $this->model->setData([
            'test' => 'test'
        ]);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->addData([
            'test_string' => 'one'
        ]);

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->addData([
            'test_string' => 'two'
        ]);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals([
            'test_string' => 'one',
            'test'        => 'test'
        ], $this->model->getData());

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals([
            'test_string' => 'two',
            'test'        => 'test'
        ], $this->model->getData());
    }

    public function testFieldStoreValuesSetIdForUnsavedModel()
    {
        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setData([
            'test_string' => 'one'
        ]);

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setData([
            'test_string' => 'two'
        ]);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals('one', $this->model->getData('test_string'));

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals('two', $this->model->getData('test_string'));

        $this->model->setStoreId(self::FIXTURE_STORE_ONE);

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->assertEquals('one', $this->model->getData('test_string'));

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->assertEquals('one', $this->model->getData('test_string'));
    }
}