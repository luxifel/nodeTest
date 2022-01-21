<?php

declare(strict_types=1);

namespace ScalapayTask\utils;

use ScalapayTask\model\DbResource;

/**
 * Class DbHelper
 * @package ScalapayTask\utils
 */
class DbHelper
{
    /**
     * @var DbResource
     */
    private $dbResource;

    /**
     * DbHelper constructor.
     * @param DbResource $dbResource
     */
    public function __construct(DbResource $dbResource)
    {
        $this->dbResource = $dbResource;
    }

    /**
     * @param array $codes
     * @return array
     */
    public function getConfigs(array $codes): array
    {
        $sql = "SELECT code, value FROM configuration WHERE code IN ('". implode("','", $codes)."')";

        try {
            $stm = $this->dbResource->getConnection()->prepare($sql);
            $stm->execute();

            return array_column($stm->fetchAll(\PDO::FETCH_ASSOC), 'value', 'code');
        } catch (\PDOException $e){
            error_log($e->getMessage());
        }
    }

}