<?php

namespace App\Commands;

use App\Models\TasksModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TaskStart extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:start';
    protected $description = 'Start a new task.';
    protected $usage       = 'task:start [task_name"]';
    protected $arguments   = ['task_name' => 'The task name to assign at the task.'];

    public function run(array $params)
    {
        $model = new TasksModel();

        if ($model->getRunningTask()) {
            CLI::write(CLI::color("Running task already set.", 'red'));
            return false;
        }

        try {
            $data = [
                'task'       => $params[0],
                'slug'       => strtolower(url_title($params[0])),
                'start_date' => date("Y-m-d H:i:s"),
            ];
            $model->save($data);
        } catch (\Exceptions $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
        $id = $model->db->insertId();
        CLI::write('Task running. ID: '.CLI::color($id, 'green'));
    }
}