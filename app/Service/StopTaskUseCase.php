<?php

namespace App\Service;

use App\Models\TaskModel;
use Exception;

/**
 * Class StopTaskUseCase
 */
class StopTaskUseCase
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
     * @param ?string $task_id
     *
     * @return void
     */
    public function __invoke(?string $task_id = null)
    {
        if (!is_null($task_id)) {
            $task = $this->task_model->find($task_id);
        } else {
            $task = $this->task_model->getRunningTask();
        }

        if (!$task || $task->stop_date != '') {
            throw new Exception("No running tasks.", 1);
        }

        $task->stop_date = date('Y-m-d H:i:s');
        return $this->task_model->save($task);
    }
}
