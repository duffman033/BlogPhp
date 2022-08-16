<?php

namespace App\Manager;

use App\Core\Database;
use App\Model\Certificate;

/**
 * CertificateManager Queries for Certificate
 */
class CertificateManager extends Database
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
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Certificate($datas));
        }

        return $custom_array;

    }
}