<?php


namespace App\Entity;

class Job
{
    private ?int $jobId = null;

    private string $name;

    private string $company;

    private string $place;

    private string $description;

    private int $startDate;

    private string $endDate;

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

    public function getJobId(): ?int
    {
        return $this->jobId;
    }

    public function setJobId($jobId): self
    {
        $this->jobId = $jobId;
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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany($company): self
    {
        $this->company = $company;
        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace($place): self
    {
        $this->place = $place;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    public function setStartDate($startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?string
    {
        return $this->endDate;
    }

    public function setEndDate($endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }
}
