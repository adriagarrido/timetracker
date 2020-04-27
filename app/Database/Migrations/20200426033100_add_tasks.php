<?php

namespace App\Database\Migrations;

use \CodeIgniter\Database\Migration;

class AddTasks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'    => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'task' => [
                'type'           => 'VARCHAR',
                'constraint'     => '128',
                'null'           => false,
            ],
            'slug'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '128',
                'null'           => false,
            ],
            'start_date'  => [
                'type'           => 'DATETIME',
                'null'           => false,
            ],
            'stop_date'  => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tasks', true);
    }

    public function down()
    {
        $this->forge->dropTable('tasks');
    }
}