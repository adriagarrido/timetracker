<?php

namespace App\Commands;

use App\Models\TaskModel;
use App\Service\StopTaskUseCase;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

class TaskStop extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:stop';
    protected $description = 'Stop current running task.';
    protected $usage       = 'task:stop';

    public function run(array $params)
    {
        try {
            $task_model = new TaskModel();
            $stop_task  = new StopTaskUseCase($task_model);
            $stop_task();
        } catch (Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
            return false;
        }
        CLI::write('Task stopped.');

        return true;
    }
}
