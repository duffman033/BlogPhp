<?php

namespace App\Manager;

use App\Core\Database;
use App\Model\Job;

/**
 * JobManager Queries for JobView
 */
class JobManager extends Database
{
    /**
     * Return Jobs
     *
     * @return array|mixed
     */
    public function getJobs()
    {
        $req = 'SELECT * FROM jobs ORDER BY start_date DESC';
        $result = $this->sql($req);
        $custom_array = [];

        while ($datas = $result->fetch(\PDO::FETCH_ASSOC)) {
            array_push($custom_array, New Job($datas));
        }

        return $custom_array;

    }

    /**
     * Return Job
     *
     * @param $jobId
     * @return array|mixed
     */
    public function getJob($jobId)
    {
        $job = 'SELECT * FROM jobs WHERE id= :id';
        $parameters = [':id' => $jobId];
        $result = $this->sql($job, $parameters);
        $data = $result->fetch(\PDO::FETCH_ASSOC);

        return new Job($data);

    }

    /**
     * Add a Job
     *
     * @param $job
     * @return bool|false|\PDOStatement
     */
    public function addJob($job)
    {
        $newJob = 'INSERT INTO jobs( name, company, place, description , start_date, end_date ) VALUES (:name, :company, :place, :description, :start_date, :end_date)';
        $parameters = [
            ':name' => $job['name'],
            ':company' => $job['company'],
            ':place' => $job['place'],
            ':description' => $job['description'],
            ':start_date' => $job['startDate'],
            ':end_date' => $job['endDate']
        ];

        $this->sql($newJob, $parameters);

    }

    /**
     * Update a Job
     *
     * @param $job
     * @return bool|false|\PDOStatement
     */
    public function updateJob($jobId, $datas)
    {
        $editedJob = 'UPDATE jobs SET name=:name, company=:company, place=:place, description=:description, start_date=:start_date, end_date=:end_date WHERE id=:id';
        $parameters = [
            ':id' => $jobId,
            ':name' => $datas['name'],
            ':company' => $datas['company'],
            ':place' => $datas['place'],
            ':description' => $datas['description'],
            ':start_date' => $datas['startDate'],
            ':end_date' => $datas['endDate']
        ];

        $this->sql($editedJob, $parameters);

    }

    /**
     * Delete a JobView
     *
     * @param $jobId
     * @return bool|false|\PDOStatement
     */
    public function deleteJob($jobId)
    {
        $job = 'DELETE FROM jobs WHERE id= :id';
        $parameters = [':id' => $jobId];

        $this->sql($job, $parameters);

    }
}