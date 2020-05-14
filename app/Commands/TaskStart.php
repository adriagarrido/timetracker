<?php

namespace App\Commands;

use App\Models\TaskModel;
use App\Service\StartTaskUseCase;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Exception;

/**
 * Class TaskStart
 */
class TaskStart extends BaseCommand
{
    protected $group       = 'Tasks';
    protected $name        = 'task:start';
    protected $description = 'Start a new task.';
    protected $usage       = 'task:start ["task_name"]';
    protected $arguments   = ['task_name' => 'The task name to assign at the task.'];

    public function run(array $params)
    {
        $task_name = '';

        // Comprobar primero que los parametros sean correctos
        if (count($params) > 1) {
            CLI::write(CLI::color("Too many options provided.", 'red'));
            CLI::write("Please, check usage with 'help task:start'.");
            return false;
        }

        // Si no tenemos nombre, preguntamos por él.
        if (empty($params)) {
            $task_name = CLI::prompt('Task name', null, 'required');
        } else {
            $task_name = $params[0];
        }

        // Con todo ok. Guardamos tarea.
        try {
            $task_model  = new TaskModel();
            $start_task  = new StartTaskUseCase($task_model);
            $id = $start_task($task_name);
        } catch (Exception $e) {
            CLI::write(CLI::color($e->getMessage(), 'red'));
            return false;
        }
        CLI::write('Task running. ID: ' . CLI::color($id, 'green'));

        return true;
    }
}
