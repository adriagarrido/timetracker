<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Service\MigrateLatestUseCase;
use App\Service\PrintTasksHtmlUseCase;
use App\Service\StartTaskUseCase;
use App\Service\StopTaskUseCase;
use CodeIgniter\Controller;
use Exception;

/**
 * Class Tasks
 */
class Tasks extends Controller
{
    /**
     * @return void
     */
    public function index()
    {
        try {
            // Esto esta mal, pero para no forzar a migrar la base de datos
            // al momento, lo hago al cargar la pagina.
            $migration_runner = \Config\Services::migrations();
            $migrateLatest    = new MigrateLatestUseCase($migration_runner);
            $migrateLatest();
        } catch (Exception $e) {
            $data['error'] = $e->getMessage();
        }

        // Ahora si, pintamos la pagina y las tareas.
        echo view('templates/header', (isset($data)) ? $data : []);

        $task_model  = new TaskModel();
        $print_tasks = new PrintTasksHtmlUseCase($task_model);
        echo $print_tasks();

        echo view('templates/footer');
    }

    /**
     * @return void
     */
    public function save()
    {
        if (defined('BASEPATH') && !$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        if (
            null === $this->request->getVar()
            || empty($this->request->getVar('task'))
        ) {
            echo 'Parametros incorrectos';
            return false;
        }

        try {
            $task_model = new TaskModel();
            if (is_null($this->request->getVar('id'))) {
                $start_task = new StartTaskUseCase($task_model);
                $task_name  = $this->request->getVar('task');
                echo $start_task($task_name);
            } else {
                $stop_task = new StopTaskUseCase($task_model);
                $task_id   = $this->request->getVar('id');
                $stop_task($task_id);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * @return void
     */
    public function getTasks()
    {
        if (defined('BASEPATH') && !$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        }

        $task_model  = new TaskModel();
        $print_tasks = new PrintTasksHtmlUseCase($task_model);
        echo $print_tasks();
    }
}
