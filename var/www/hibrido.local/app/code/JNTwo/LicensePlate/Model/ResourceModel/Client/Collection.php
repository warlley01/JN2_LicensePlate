<?php
namespace JNTwo\LicensePlate\Model\ResourceModel\Client;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'jntwo_licenseplate_clients_collection';
    protected $_eventObject = 'clients_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('JNTwo\LicensePlate\Model\Client', 'JNTwo\LicensePlate\Model\ResourceModel\Client');
    }

}

