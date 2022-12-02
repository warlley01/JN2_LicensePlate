<?php
namespace JNTwo\LicensePlate\Model\ResourceModel;


class Client extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context
    )
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('jntwo_licenseplate_clients', 'entity_id');
    }

}
