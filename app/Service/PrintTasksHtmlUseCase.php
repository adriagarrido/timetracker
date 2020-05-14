<?php

namespace App\Service;

use App\Models\TaskModel;

/**
 * Class PrintTasksHtmlUseCase
 */
class PrintTasksHtmlUseCase
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
     * @return void
     */
    public function __invoke()
    {
        $tasks_order_by_date = $this->task_model->getTasks();
        return view('pages/body', ['tasks' => $tasks_order_by_date]);
    }
}
