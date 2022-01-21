<?php

declare(strict_types=1);

namespace ScalapayTask\model;

/**
 * Class DbResource
 * @package ScalapayTask\model
 */
class DbResource
{
    /**
     * @var string
     */
    private $host;

    /**
     *
     * @var string
     */
    private $dbName;

    /**
     *
     * @var string
     */
    private $user;

    /**
     *
     * @var string
     */
    private $pwd;

    /**
     * @var \PDO|null
     */
    private $dbConn = null;



    public function __construct()
    {
        $dbData = parse_ini_file('../configs.ini', true);

        $this->host = $dbData['db']['host'];
        $this->dbName = $dbData['db']['dbName'];
        $this->user = $dbData['db']['user'];;
        $this->pwd = $dbData['db']['password'];

        try {
            $this->dbConn = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbName . ';charset=utf8',
                $this->user, $this->pwd);
        } catch(\PDOException $e){
            http_response_code(500);
            error_log($e->getMessage() . "\n" . $e->getTraceAsString());
            exit();
        }
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->dbConn;
    }

}