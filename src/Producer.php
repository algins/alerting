<?php

namespace Alerting\Producer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function publish(): void
{
    $connection = new AMQPStreamConnection(
        $_ENV['AMQP_HOST'],
        $_ENV['AMQP_PORT'],
        $_ENV['AMQP_USER'],
        $_ENV['AMQP_PASSWORD'],
    );

    $channel = $connection->channel();
    $channel->exchange_declare('alerts', 'direct');

    $data = 'info: Hello World!';
    $msg = new AMQPMessage($data);
    $channel->basic_publish($msg, 'alerts');

    echo ' [x] Sent ', $data, "\n";

    $channel->close();
    $connection->close();
}
