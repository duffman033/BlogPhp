<?php

namespace App\Respository;

use App\Core\Database;
use App\Entity\Certificate;
use PDO;

/**
 * CertificateRespository Queries for Certificate
 */
class CertificateRespository extends Database
{
    /**
     * Return Certificate
     *
     * @return array|mixed
     */
    public function getCertificate()
    {
        $req = 'SELECT * FROM certificate ORDER BY date DESC';
        $result = $this->sql($req);
        $customArray = [];

        while ($datas = $result->fetch(PDO::FETCH_ASSOC)) {
            array_push($customArray, new Certificate($datas));
        }

        return $customArray;
    }
}
