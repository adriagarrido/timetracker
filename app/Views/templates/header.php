<!doctype html>
<html lang="en">

<head>
  <title>Timetracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" 
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" 
    crossorigin="anonymous" ></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" 
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" 
    crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" 
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" 
    crossorigin="anonymous" ></script>
  <script src="https://kit.fontawesome.com/3b1712d86a.js" crossorigin="anonymous"></script>
  <script>
    var BASE_URL = "<?php echo base_url(); ?>";
  </script>
</head>

<body style="padding-top: 71px; padding-bottom: 71px;">
  <nav class="navbar fixed-top navbar-light bg-light shadow-sm ">
    <form class="form-inline d-inline w-100">
      <div class="input-group">
        <input id="input-task" type="text" class="form-control" placeholder="What are you working on?">
        <input id="hidden-id" type="hidden">
        <div class="input-group-append">
          <span id="screen" class="input-group-text">0:00:00</span>
          <button id="btn-startstop" class="btn btn-success" type="button">
            <i id="btn-value" class="fas fa-play"></i>
          </button>
        </div>
      </div>
    </form>
  </nav>
  <div class="container-fluid">
    <?php if (isset($error)) : ?>
      <div class="alert alert-danger">
        <p><?= esc($error); ?></p>
      </div>
    <?php endif; ?>
    <div id="tasks-list">