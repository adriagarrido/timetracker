<?php

namespace App\Service;

use App\Entities\Task;
use App\Models\TaskModel;
use Exception;

final class StartTaskUseCase
{
    /**
     * @var TaskModel
     */
    private TaskModel $task_model;

    /**
     * @param TaskModel $a_task_model
     *
     * @return void
     */
    public function __construct(TaskModel $a_task_model)
    {
        $this->task_model = $a_task_model;
    }

    /**
     * @param string $a_task_name
     *
     * @return void
     */
    public function __invoke(string $a_task_name)
    {
        if ($a_task_name === '') {
            throw new Exception("Task must have a name.", 1);
        }

        $running_task = $this->task_model->getRunningTask();
        if ($running_task) {
            throw new Exception("Task already running.", 1);
        }

        $data = array(
            'task'       => $a_task_name,
            'slug'       => strtolower(url_title($a_task_name)),
            'start_date' => date('Y-m-d H:i:s'),
        );
        $task = new Task($data);
        $this->task_model->save($task);

        return $this->task_model->db->insertId();
    }
}
