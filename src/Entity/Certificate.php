<?php


namespace App\Entity;


class Certificate
{
    /**
     * @var int $certificate_id id
     */
    private $certificateId;

    /**
     * @var string $name name
     */
    private $name;

    /**
     * @var int $date date
     */
    private $date;

    public function __construct($datas = [])
    {
        if (!empty($datas)) {
            $this->hydrate($datas);
        }
    }

    public function hydrate($datas)
    {

        foreach ($datas as $key => $value) {
            $key = lcfirst(str_replace('_', '', ucwords($key, '_')));
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return int
     */
    public function getCertificateId()
    {
        return $this->certificateId;
    }

    /**
     * @param int $certificateId
     */
    public function setCertificateId($certificateId)
    {
        $this->certificateId = $certificateId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}