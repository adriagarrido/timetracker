<div class="card bg-light">
  <div class="card-header text-center">
    Today: <em id="totaltime"><?= number_format($total_time, 2); ?>h</em>
  </div>
  <ul id="task-list" class="list-group list-group-flush">
      <?php foreach ($tasks as $task): ?>
         <?php
         $total    = ($task['interval']) / 60 / 60;
         $interval = intdiv(round($total * (10 ** 2)), 1) / (10 ** 2);
         ?>
         <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo $task['task']; ?>
            <span class="badge badge-primary badge-pill"><?= ($interval == 0)? '<': ''; ?> <?= number_format($interval, 2); ?>h</span>
         </li>
      <?php endforeach; ?>
  </ul>
</div>