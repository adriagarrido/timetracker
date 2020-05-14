<?php foreach ($tasks as $date => $data) : ?>
  <div class="card bg-light" style="margin-bottom: 15px;">
    <div class="card-header text-center">
      <?php echo $date; ?>: <em id="totaltime"><?php echo $data['total']; ?></em>
    </div>
    <ul id="task-list" class="list-group list-group-flush">
      <?php foreach ($data['tasks'] as $task) : ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?php echo $task['name']; ?>
          <span class="badge badge-primary badge-pill">
            <?php echo $task['time_spend']; ?>
          </span>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endforeach; ?>