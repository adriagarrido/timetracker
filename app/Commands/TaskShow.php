<?php

namespace App\Commands;

use App\Models\TaskModel;
use App\Service\PrintTasksCLIUseCase;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class TaskShow extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:show';
    protected $description = 'Show all the tasks.';
    protected $usage       = 'task:show';

    public function run(array $params)
    {
        $task_model  = new TaskModel();
        $cli_runner  = new CLI();
        $print_tasks = new PrintTasksCLIUseCase($task_model, $cli_runner);
        $print_tasks();
    }
}
