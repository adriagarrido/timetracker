# Timetracker

This is a simple time tracker app.

It's build with [CodeIgniter](http://codeigniter.com), and requires docker-compose to work.

## Table of contents
- [tl;dr;](#tl;dr;)
- [Installation](#installation)
- [Usage](#usage)
- [Update](#update)

## tl;dr;

> All of us are a bit lazy sometimes, don't worry...

### First time installation

Run the following commands:

```
$ mkdir timetracker && cd timetracker
$ wget https://raw.githubusercontent.com/adriagarrido/timetracker/master/docker-compose.yml
$ docker-compose up -d && docker-compose exec webapp php spark migrate
```
### How to use
Open the following url in your explorer: [http://localhost:8080](http://localhost:8080) to use the graphic web app.

If you prefer use the CLI can use the following commands from the timetracker folder:

```
$ docker-compose exec webapp php spark task:start ["name of the task"]
$ docker-compose exec webapp php spark task:stop
$ docker-compose exec webapp php spark task:show
```

## Installation

This webapp use docker-compose in order to work. [Check the installation page from the creators](https://docs.docker.com/compose/install/) if you doesn't have it installed.

Make a directory, download the [docker-compose.yml](https://raw.githubusercontent.com/adriagarrido/timetracker/master/docker-compose.yml) file in it.

```
$ mkdir timetracker && cd timetracker
$ wget https://raw.githubusercontent.com/adriagarrido/timetracker/master/docker-compose.yml
```

Once you have it in your system up the webapp and migrate the database.
```
$ docker-compose up -d && docker-compose exec webapp php spark migrate
```

That's all.

## Usage

This is a webapp so, there is a graphic web app. Also, ther are some cli commands if you prefer the terminal.

### Web

Enter at [localhost with port 8080](http://localhost:8080).

There is a input field at the top, and a play ▶ button. Just type the name of the task and click the ▶.

To stop the task, click on the ⏹ button and the task will appear at the list below showing the time.

### Terminal

There are three commands you can type to work with the app.

To start a new task type the following command. The name of the task param is optional, if you don't type it on the command, a prompt will appear to ask the name.
```
$ docker-compose exec webapp php spark task:start ["name of the task"]
```

To stop the current task type:
```
$ docker-compose exec webapp php spark task:stop
```

To view the tasks and it time agrouped by date, type:
```
$ docker-compose exec webapp php spark task:show
```

### Stop timetracker app

To stop the app run `docker-compose down`.

## Update

To update the image just type:

```
$ docker-compose pull webapp
```

and the latest version of the image will download.

