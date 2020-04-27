<?php

namespace App\Commands;

use App\Models\TasksModel;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TaskStop extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:stop';
    protected $description = 'Stop current running task.';
    protected $usage       = 'task:stop';

    public function run(array $params)
    {
        $model = new TasksModel();

        $id = $model->getRunningTask();

        if (! $id) {
            CLI::write('No running tasks.');
            return false;
        }

        try {
            $data = [
                'id' => $id,
                'stop_date' => date("Y-m-d H:i:s"),
            ];
            $model->save($data);
        } catch (\Exceptions $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
        }
        $id = $model->db->insertId();
        CLI::write('Task stopped. ID: '.CLI::color($id, green));
    }
}