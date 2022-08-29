<?php


namespace App\Entity;

class Skill
{
    /**
     * @var int $skill_id id
     */
    private int $skillId;

    /**
     * @var string $name name
     */
    private string $name;

    /**
     * @var int $progress progress
     */
    private int $progress;

    /**
     * @var string $type type
     */
    private string $type;


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
    public function getSkillId()
    {
        return $this->skillId;
    }

    /**
     * @param int $skillId
     */
    public function setSkillId($skillId)
    {
        $this->skillId = $skillId;
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
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param int $progress
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
