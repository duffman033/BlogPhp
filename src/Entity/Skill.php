<?php


namespace App\Entity;

class Skill
{
    private ?int $skillId = null;

    private string $name;

    private int $progress;

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

    public function getSkillId(): ?int
    {
        return $this->skillId;
    }

    public function setSkillId($skillId): self
    {
        $this->skillId = $skillId;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getProgress(): ?int
    {
        return $this->progress;
    }

    public function setProgress($progress): self
    {
        $this->progress = $progress;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }
}
