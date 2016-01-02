<?php

namespace AllBear\StoreFieldSugar\Model;

class AbstractModel extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManger;

    /**
     * Like DataObject _data, but related for stores
     *
     * @var array
     */
    protected $_store_field_data = [];

    /**
     * Config, which contains data about store related fields and they types (in DB)
     *
     * @var array
     */
    protected $_store_field_config = [];

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->storeManager = $storeManager;

        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @param $fieldName
     * @param $type
     */
    protected function _initStoreField($fieldName, $type)
    {
        $this->_store_field_config[$fieldName] = $type;
    }

    /**
     * Get current store id or setted store id
     *
     * @return int
     */
    public function getStoreId()
    {
        if ($storeId = parent::getStoreId()) {
            return $storeId;
        }

        return $this->storeManager->getStore()->getId();
    }

    /**
     * @param $key
     * @param $storeId
     * @return array|null
     */
    private function _getStoreFieldData($key, $storeId)
    {
        $data = isset($this->_store_field_data[$storeId]) ? $this->_store_field_data[$storeId] : [];

        if (!$key) {
            return $data;
        }

        return isset($data[$key]) ? $data[$key] : null;
    }

    /**
     * Get store related data
     *
     * @param null $key
     * @param null $storeId
     * @return array|mixed
     */
    public function getStoreFieldData($key = null, $storeId = null)
    {
        if (is_null($storeId)) {
            $storeId = $this->getStoreId();
        }

        return $this->_getStoreFieldData($key, $storeId);
    }

    /**
     * @param $key
     * @return bool
     */
    private function isStoreRelatedField($key)
    {
        return isset($this->_store_field_config[$key]);
    }

    /**
     * {@inheritdoc}
     */
    public function getData($key = '', $index = null)
    {
        if (!$key) {
            return array_merge($this->getStoreFieldData(), parent::getData());
        }

        if (!$this->isStoreRelatedField($key)) {
            return parent::getData($key);
        }

        return $this->getStoreFieldData($key);
    }

    /**
     * @param $storeId
     */
    protected function initStoreData($storeId)
    {
        if (!isset($this->_store_field_data[$storeId])) {
            $this->_store_field_data[$storeId] = [];
        }
    }

    /**
     * @param null $key
     * @param null $value
     * @param $storeId
     */
    private function _setStoreFieldData($key = null, $value = null, $storeId)
    {
        $this->initStoreData($storeId);

        if ($key === (array)$key) {
            $this->_store_field_data[$storeId] = $key;
        } else {
            $this->_store_field_data[$storeId][$key] = $value;
        }
    }

    /**
     * Set store related data
     *
     * @param $key
     * @param null $value
     * @param null $storeId
     */
    public function setStoreFieldData($key, $value = null, $storeId = null)
    {
        if (is_null($storeId)) {
            $storeId = $this->getStoreId();
        }

        $this->_setStoreFieldData($key, $value, $storeId);
    }

    /**
     * {@inheritdoc}
     */
    public function setData($key, $value = null)
    {
        if ($key === (array)$key) {
            $storeData = array_intersect_key($key, $this->_store_field_config);
            $this->setStoreFieldData($storeData);

            parent::setData(array_diff_key($key, $storeData), $value);
        } else {
            if ($this->isStoreRelatedField($key)) {
                $this->setStoreFieldData($key, $value);
            } else {
                return parent::setData($key, $value);
            }
        }

        return $this;
    }
}