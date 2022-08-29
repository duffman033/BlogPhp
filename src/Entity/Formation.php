<?php


namespace App\Entity;


class Formation
{
    /**
     * @var int $formation_id id
     */
    private int $formationId;

    /**
     * @var string $name name
     */
    private string $name;

    /**
     * @var string $school school
     */
    private string $school;

    /**
     * @var string $place place
     */
    private string $place;

    /**
     * @var string $description description
     */
    private string $description;

    /**
     * @var int $startDate start_date
     */
    private int $startDate;

    /**
     * @var int $endDate end_date
     */
    private int $endDate;

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
    public function getFormationId()
    {
        return $this->formationId;
    }

    /**
     * @param int $formationId
     */
    public function setFormationId($formationId)
    {
        $this->formationId = $formationId;
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
     * @return string
     */
    public function getSchool()
    {
        return $this->school;
    }

    /**
     * @param string $school
     */
    public function setSchool($school)
    {
        $this->school = $school;
    }

    /**
     * @return string
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param string $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }


    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param int $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return int
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param int $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
}
