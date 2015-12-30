<?php

namespace AllBear\StoreFieldSugar\Test\Integration;

class Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \AllBear\StoreFieldSugar\Test\Integration\Data\Model\Test
     */
    protected $model;

    protected $objectManager;

    /**
     * @var \Magento\Store\Model\StoreManager
     */
    protected $storeManager;

    protected function setUpStoreManager()
    {
        $storeRepository   = $this->objectManager->getObject('\Magento\Store\Api\StoreRepositoryInterface');
        $groupRepository   = $this->objectManager->getObject('\Magento\Store\Api\GroupRepositoryInterface');
        $websiteRepository = $this->objectManager->getObject('\Magento\Store\Api\WebsiteRepositoryInterfacee');
        $scopeConfig       = $this->objectManager->getObject('\Magento\Framework\App\Config\ScopeConfigInterface');
        $storeResolver     = $this->objectManager->getObject('Magento\Store\Model\StoreResolverInterface');
        $cache             = $this->objectManager->getObject('\Magento\Framework\Cache\FrontendInterface');

        $this->storeManager = $this->getMockBuilder('Magento\Store\Model\StoreManager')
                                   ->setMethods(null)
                                   ->setConstructorArgs($storeRepository, $groupRepository, $websiteRepository, $scopeConfig, $storeResolver, $cache);
    }

    protected function setUp()
    {
        $this->objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);

        $this->setUpStoreManager();

        $this->model = $this->objectManager->getObject('AllBear\StoreFieldSugar\Test\Integration\Data\Model\Test');
    }

    public function testInitialization()
    {
        $this->assertNotNull($this->model);
    }

    protected function useStore($storeId)
    {
        $this->
    }

    public function testFieldStoreValuesForUnsavedModel()
    {
        $this->useStore(1);
        $this->model->setTestString('one');

        $this->useStore(2);
        $this->model->setTestString('two');

        $this->useStore(1);
        $this->assertEquals('one', $this->model->getTestString());

        $this->useStore(2);
        $this->assertEquals('two', $this->model->getTestString());
    }
}