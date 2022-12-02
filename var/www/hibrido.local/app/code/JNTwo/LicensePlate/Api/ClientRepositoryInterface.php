<?php
namespace JNTwo\LicensePlate\Api;

interface ClientRepositoryInterface {

    /**
     * @param int $id
     * @return string[]
     */
    public function getClientById($id);

    /**
     * @param int $id
     * @param string $name
     * @param string $number
     * @param string $taxvat
     * @param string $licensePlate
     * @return string
     */
    public function updateClient($id, $name, $number, $taxvat, $licensePlate);

    /**
     * @param mixed $clientInfo
     * @return void
     */
    public function createClient($clientInfo);

    /**
     * @param int $id
     * @return string
     */
    public function deleteClient($id);

    /**
     * @param int $number
     * @return string[]
     */
    public function searchByLicenseEndPlate($number);
}
