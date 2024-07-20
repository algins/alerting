<?php

namespace Alerting\Consumer;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PHPMailer\PHPMailer\PHPMailer;
use Throwable;

function consume(): void
{
    $connection = new AMQPStreamConnection(
        $_ENV['AMQP_HOST'],
        $_ENV['AMQP_PORT'],
        $_ENV['AMQP_USER'],
        $_ENV['AMQP_PASSWORD'],
    );

    $channel = $connection->channel();
    $channel->exchange_declare('alerts', 'direct');
    $channel->queue_declare('emails');
    $channel->queue_bind('emails', 'alerts');

    echo " [*] Waiting for alerts. To exit press CTRL+C\n";

    $channel->basic_consume('emails', callback: function (AMQPMessage $msg) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->Port = $_ENV['SMTP_PORT'];
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;

            $mail->setFrom($_ENV['MAIL_FROM_ADDRESS']);
            $mail->addAddress($_ENV['MAIL_TO_ADDRESS']);

            $mail->isHTML(false);
            $mail->Subject = 'Alert';
            $mail->Body = $msg->getBody();

            $mail->send();
            echo ' [x] ', $msg->getBody(), "\n";
        } catch (Throwable $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    });

    try {
        $channel->consume();
    } catch (Throwable $e) {
        echo $e->getMessage();
    }

    $channel->close();
    $connection->close();
}
