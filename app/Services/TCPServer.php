<?php

$server = new Swoole\Server("127.0.0.1", 9501, SWOOLE_BASE, SWOOLE_SOCK_TCP);

$server->set([
    'worker_num' => 1,   // The number of worker processes
    'backlog' => 128,    // TCP backlog connection number
]);

$server->on('connect', function(Swoole\Server $server, int $fd, int $reactorID) {
    $server->send($fd, 'Your ID: ' . $fd);
    $server->send($fd, 'Your ReactorID: ' . $reactorID);
});

$server->on('receive', function(Swoole\Server $server, int $fd, int $reactorID, string $data) {
    foreach ($server->connections as $connection) {
        $server->send($connection, $data . "\n");
    }
});

$server->on('close', function() {
    // ...
});

$server->start();
