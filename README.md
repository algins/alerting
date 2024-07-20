# Alerting
The fire-and-forget alerting application using RabbitMQ and PHP.

### Requirements:
* Git
* Make
* Docker, Docker Compose

### Clone:
```sh
$ git clone https://github.com/algins/alerting.git && cd alerting
```

### Setup:
```sh
$ make setup
```

### Start:
```sh
$ make start
```

### Stop:
```sh
$ make stop
```

### Lint:
```sh
$ make lint
```

### Usage:
```sh
$ make publish 

# After publishing open http://localhost:8025 in browser and check your email for incoming alerts.
```
