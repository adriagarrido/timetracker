<?php

namespace App\Models;

use CodeIgniter\Model;

class TasksModel extends Model
{
    protected $table = 'tasks';

    protected $allowedFields = ['task', 'slug', 'start_date', 'stop_date'];

    public function getTasks()
    {
        $tasks = $this->findAll();

        $return = [];
        foreach ($tasks as $task) {
            if (isset($return[$task['slug']])) {
                $return[$task['slug']]['interval'] += $this->getInterval($task['id']);
            } else {
                $return[$task['slug']] = $task;
                $return[$task['slug']]['interval'] = $this->getInterval($task['id']);
            }
        }

        return $return;
    }

    public function getRunningTask()
    {
        $task = $this->asArray()
                    ->where(['stop_date' => null])
                    ->first();

        if (empty($task)) {
            return false;
        }
        
        return $task['id'];
    }

    public function getInterval($id)
    {
        $task = $this->asArray()
                    ->where(['id' => $id])
                    ->first();
        
        $start    = new \DateTime($task['start_date']);
        $stop     = new \DateTime($task['stop_date']);
        $interval = $start->diff($stop);
        $hours    = $interval->format('%h') * 60 * 60;
        $minutes  = $interval->format('%I') * 60;
        $seconds  = $interval->format('%S');

        return $hours + $minutes + $seconds;
    }

    public function getTotalTime()
    {
        $tasks      = $this->findAll();
        $total_time = '0';
        foreach ($tasks as $task) {
            $total_time += $this->getInterval($task['id']);
        }
        
        return $total_time / 60 / 60;
    }
}