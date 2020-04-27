# Timetracker

This is a simple time tracker app.

It's build with [CodeIgniter](http://codeigniter.com), and requires docker-compose to work.

## Install and Use

Make a directory, download the [docker-compose.yml]() in it. Run `docker-compose up -d` and access to the localhost at the 8080 port.

To stop the app run `docker-compose down`.

### Use the cli

The app has 2 commands to start and stop tasks.

Start a new task with `docker-compose exec webapp php spark task:start "name of the task"`.
And stop the current running task with `docker-compose exec webapp php spark task:stop`.
