<?php
/**
 * Created by PhpStorm.
 * User: mimidots
 * Date: 6/2/2018
 * Time: 8:13 AM
 */

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use io\Chat;
use Ratchet\WebSocket\WsServer;

require_once 'vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
        new Chat()
    )
    ),8000
);

$server->run();