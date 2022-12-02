<?php
namespace JNTwo\LicensePlate\Model\Api;

use Magento\Setup\Exception;

class ClientRepository {

    protected $client;
    protected $clientResource;
    protected $clientCollection;
    protected $logger;

    public function __construct(
        \JNTwo\LicensePlate\Model\ClientFactory $client,
        \JNTwo\LicensePlate\Model\ResourceModel\Client $clientResource,
        \JNTwo\LicensePlate\Model\ResourceModel\Client\CollectionFactory $clientCollection,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->client = $client;
        $this->clientResource = $clientResource;
        $this->clientCollection = $clientCollection;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function getClientById($id)
    {
        $client = $this->clientCollection->create()->addFieldToFilter("entity_id", $id)->getFirstItem();

        if (!$client->getId()) {
            $message = "Client not found";
            return $message;
        }

        $clientInfo = [[
            'ID' => $client->getId(),
            'Nome' => $client->getName(),
            'Telefone' => $client->getNumber(),
            'CPF' => $client->getTaxvat(),
            'Placa do Carro' => $client->getLicensePlate()
        ]];

        return $clientInfo;
    }

    /**
     * {@inheritdoc}
     */
    public function updateClient($id, $name, $number, $taxvat, $licensePlate)
    {
        try {
            $clientInfo = [
                'name' => $name,
                'number' => $number,
                'taxvat' => $taxvat,
                'license_plate' => $licensePlate
            ];

            $this->validate($clientInfo);

            $client = $this->clientCollection->create()->addFieldToFilter("entity_id", $id)->getFirstItem();

            $client->setName($name);
            $client->setNumber($number);
            $client->setTaxvat($taxvat);
            $client->setLicensePlate($licensePlate);

            $this->clientResource->save($client);

        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $this->logger->critical($e);

            return $e->getMessage();
        }

        return "Client updated successfully";
    }

    /**
     * {@inheritdoc}
     */
    public function createClient($clientInfo)
    {
        try {
            $this->validate($clientInfo);

            $client = $this->client->create();

            $client->setName($clientInfo['name']);
            $client->setNumber($clientInfo['number']);
            $client->setTaxvat($clientInfo['taxvat']);
            $client->setLicensePlate($clientInfo['license_plate']);

            $this->clientResource->save($client);

        } catch (\Exception $e) {
            $this->logger->critical($e->getMessage());
            $this->logger->critical($e);

            return $e->getMessage();
        }

        $message = "Client " .$clientInfo['name']. " created";

        return $message;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteClient($id)
    {
        $client = $this->clientCollection->create()->addFieldToFilter("entity_id", $id)->getFirstItem();
        $this->clientResource->delete($client);

        return "Client deleted";
    }

    /**
     * {@inheritdoc}
     */
    public function searchByLicenseEndPlate($number)
    {
        $clients = $this->clientCollection->create()->addFieldToFilter("license_plate", array("like" => "%" . $number));

        $clientsList = [];
        foreach ($clients as $client) {
            $clientInfo = [[
                'ID' => $client->getId(),
                'Nome' => $client->getName(),
                'Telefone' => $client->getNumber(),
                'CPF' => $client->getTaxvat(),
                'Placa do Carro' => $client->getLicensePlate()
            ]];

            array_push($clientsList, $clientInfo);
        }

        if(count($clientsList) === 0) {
            return "No license plate found with end: " . $number;
        }

        return $clientsList;
    }

    public function validate($clientInfo)
    {
        $searchTaxvat = $this->clientCollection->create()->addFieldToFilter("taxvat", $clientInfo['taxvat']);
        $searchLicensePlate = $this->clientCollection->create()->addFieldToFilter("license_plate", $clientInfo['license_plate']);

        if (count($searchTaxvat) > 0) {
            throw new \Exception("Taxvat already exists");
        }

        if (count($searchLicensePlate) > 0) {
            throw new \Exception("License Plate already exists");
        }
    }
}
