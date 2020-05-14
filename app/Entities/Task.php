<?php

namespace App\Entities;

use CodeIgniter\Entity;
use DateTime;

/**
 * Class Task
 */
class Task extends Entity
{
    /**
     * @return void
     */
    public function getInterval()
    {
        $start    = new DateTime($this->start_date);
        $stop     = new DateTime($this->stop_date);
        $interval = $start->diff($stop);
        $result   = ($interval->format('%h') * 60 * 60)
                  + ($interval->format('%I') * 60)
                  + ($interval->format('%S'));

        return $result;
    }

    // /**
    //  * @return void
    //  */
    // public function getTimeSpend()
    // {
    //     if (is_null($this->stop_date)) {
    //         return 'running';
    //     }

    //     $hours = $this->getInterval() / 60 / 60;
    //     $total = intdiv(round($hours * (10 ** 2)), 1) / (10 ** 2);

    //     $time_spend = '';
    //     if ($total == 0) {
    //         $time_spend = '< ';
    //     }
    //     $time_spend .= number_format($total, 2) . 'h';

    //     return $time_spend;
    // }
}
