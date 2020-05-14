<?php

namespace App\Models;

use CodeIgniter\Model;
use DateTime;
use Exception;

/**
 * Class TaskModel
 *
 * La mayoria de funciones del modelo no tengo claro si tienen que ir aquí
 * o si hay algún concepto de aquitectura que se ajuste mejor a ellas.
 */
class TaskModel extends Model
{
    /**
     * @var string
     */
    protected $table         = 'tasks';
    /**
     * @var array
     */
    protected $allowedFields = ['task', 'slug', 'start_date', 'stop_date'];
    /**
     * @var string
     */
    protected $returnType    = 'App\Entities\Task';
    /**
     * @var boolean
     */
    protected $useTimestamps = false;

    /**
     * @param ?DateTime $a_start_date
     * @param ?string $a_task_slug
     *
     * @return void
     */
    private function getTotalTimeSpend(?DateTime $a_start_date, ?string $a_task_slug = null)
    {
        if ($a_task_slug === '') {
            throw new Exception("Wrong params.", 1);
        }

        if (!is_null($a_task_slug)) {
            $tasks = $this->where('slug', $a_task_slug)
                ->like('start_date', $a_start_date->format('Y-m-d'))
                ->where('stop_date !=', null)
                ->findAll();
        } else {
            $tasks = $this->like('start_date', $a_start_date->format('Y-m-d'))
                ->where('stop_date !=', null)
                ->findAll();
        }

        $time_spend = '';
        $total = 0;
        $hours = 0;
        foreach ($tasks as $task) {
            $hours += $task->getInterval() / 60 / 60;
        }
        $total = intdiv(round($hours * (10 ** 2)), 1) / (10 ** 2);
        if ($total == 0) {
            $time_spend = '< ';
        }
        $time_spend .= number_format($total, 2) . 'h';

        return $time_spend;
    }

    /**
     * @return void
     */
    public function getTasks()
    {
        $tasks = $this->where('stop_date !=', null)
            ->orderBy('stop_date', 'DESC')
            ->findAll();

        $format = 'F jS, Y';
        $today  = new DateTime();
        $today  = $today->format($format);

        $tasks_ordered_by_date = [];
        foreach ($tasks as $task) {
            $date = new DateTime($task->start_date);
            $date_formated = $date->format('F jS, Y');
            if ($date_formated === $today) {
                $date_formated = 'Today';
            }
            if (!isset($tasks_ordered_by_date[$date_formated])) {
                $tasks_ordered_by_date[$date_formated] = array(
                    'total' => $this->getTotalTimeSpend($date),
                    'tasks' => array(),
                );
            }
            if (!isset($tasks_ordered_by_date[$date_formated]['tasks'][$task->slug])) {
                $tasks_ordered_by_date[$date_formated]['tasks'][$task->slug] = array(
                    'name' => $task->task,
                    'time_spend' => $this->getTotalTimeSpend($date, $task->slug),
                );
            }
        }

        return $tasks_ordered_by_date;
    }

    /**
     * @return void
     */
    public function getRunningTask()
    {
        $task = $this->where(['stop_date' => null])
            ->first();

        if (empty($task)) {
            return false;
        }

        return $task;
    }
}
