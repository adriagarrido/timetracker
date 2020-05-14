<?php

namespace App\Service;

use App\Models\TaskModel;
use CodeIgniter\CLI\CLI;

class PrintTasksCLIUseCase
{
    /**
     * @var TaskModel
     */
    private TaskModel $task_model;
    /**
     * @var CLI
     */
    private CLI $cli_runner;

    /**
     * @param TaskModel $a_task_model
     * @param CLI $a_cli_runner
     *
     * @return void
     */
    public function __construct(TaskModel $a_task_model, CLI $a_cli_runner)
    {
        $this->task_model = $a_task_model;
        $this->cli_runner = $a_cli_runner;
    }

    /**
     * @return void
     */
    public function __invoke()
    {
        $tasks_order_by_date = $this->task_model->getTasks();
        foreach ($tasks_order_by_date as $date => $data) {
            $thead = [$date, $data['total']];
            $tbody = array();
            foreach ($data['tasks'] as $task) {
                $task_data = [
                    $task['name'],
                    $task['time_spend'],
                ];
                array_push($tbody, $task_data);
            }
            $this->cli_runner->table($tbody, $thead);
        }
    }
}
