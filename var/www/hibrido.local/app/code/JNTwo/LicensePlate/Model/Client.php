<?php
namespace JNTwo\LicensePlate\Model;

class Client extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'jntwo_licenseplate_clients';
    protected $_cacheTag = 'jntwo_licenseplate_clients';
    protected $_eventPrefix = 'jntwo_licenseplate_clients';

    protected function _construct()
    {
        $this->_init('JNTwo\LicensePlate\Model\ResourceModel\Client');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];
        return $values;
    }
}
