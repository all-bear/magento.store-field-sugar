<?php

namespace AllBear\StoreFieldSugar\Test\Integration\Model;

class Test extends AbstractTest
{
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
        $this->model->setData('test_string', 'one');

        $this->useStore(self::FIXTURE_STORE_TWO);
        $this->model->setData('test_string', 'two');

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

    public function testFieldStoreValuesHasDataChangesDataForUnsavedModel()
    {
        $this->assertEquals(false, $this->model->hasDataChanges());

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setData('test_string', 'one');

        $this->assertEquals(true, $this->model->hasDataChanges());
    }

    public function testFieldStoreValuesHasDataChangesValueForUnsavedModel()
    {
        $this->assertEquals(false, $this->model->hasDataChanges());

        $this->useStore(self::FIXTURE_STORE_ONE);
        $this->model->setTestString('one');

        $this->assertEquals(true, $this->model->hasDataChanges());
    }
}