<?php

namespace App\Controllers;

use App\Models\TasksModel;
use CodeIgniter\Controller;

class Tasks extends Controller
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try
        {
            $migrate->latest();
        }
        catch (\Exception $e)
        {
            $data['error'] = $e->getMessage();
        }

        $model = new TasksModel();

        $data['tasks']      = $model->getTasks();
        $data['total_time'] = $model->getTotalTime();

        echo view('templates/header', $data);
        echo view('pages/body');
        echo view('templates/footer');
    }

    public function save()
    {
        if (defined('BASEPATH') && !$this->input->is_ajax_request()) {
            exit('No direct script access allowed'); 
        }

        $model = new TasksModel();

        try {
            $data = [
                'task' => $this->request->getVar('task'),
                'slug'  => strtolower(url_title($this->request->getVar('task'))),
            ];
            if (null !== $this->request->getVar('id')) {
                $data['id'] = $this->request->getVar('id');
                $data['stop_date'] = $this->request->getVar('date');
            } else {
                if ($model->getRunningTask()) {
                    throw new Exception("Running task already set.", 1);
                }
                $data['start_date'] = $this->request->getVar('date');
            }
            $model->save($data);
        } catch (\Exceptions $e) {
            echo $e->getMessage();
        }
        $id = $model->db->insertId();
        echo $id;
    }

    public function getTasks()
    {
        if (defined('BASEPATH') && !$this->input->is_ajax_request()) {
            exit('No direct script access allowed'); 
        }

        $model = new TasksModel();

        $tasks = $model->getTasks();

        try {
            $html_tasks = '';
            foreach ($tasks as $task) {
                $total    = ($task['interval']) / 60 / 60;
                $time = ($total == 0)? '<': '' . ' ' . number_format($total, 2);
                if ($time == 0) {
                    $time = '< '.$time;
                }
                $html_tasks .= '<li class="list-group-item d-flex justify-content-between align-items-center">'
                . $task['task']
                . '<span class="badge badge-primary badge-pill">'. $time .'h</span>'
                . '</li>';
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        echo $html_tasks;
    }

    public function getTime()
    {
        if (defined('BASEPATH') && !$this->input->is_ajax_request()) {
            exit('No direct script access allowed'); 
        }

        try {
            $model = new TasksModel();
        
            echo $model->getTotalTime();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}