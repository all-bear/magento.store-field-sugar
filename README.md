# Store Field Sugar
Magento 2 library, which allows simply add store related model fields.

# How to use it
You must to extend you model from `AllBear\StoreFieldSugar\Model\AbstractModel` and initialize you fields in constructor with types. Example:
```php
use Magento\Framework\DB\Ddl\Table;

class Test extends \AllBear\StoreFieldSugar\Model\AbstractModel
{
    protected function _construct()
    {
        ... \\same initialization like for a simple model

        $this->_initStoreField('test_string', Table::TYPE_TEXT); \\init store field with name 'test_string' and with type 'text'
    }
}
```
Now you can use your model like EAV model.
For more info you can look to unit test :)

# TODO
- implement methods for collection like a addFieldToFilter, etc.