<?php

require_once 'vendor/autoload.php';

use React\EventLoop\Factory;
use React\Stream\DuplexResourceStream;
use React\Stream\ReadableResourceStream;

$streamList = [
  new ReadableResourceStream(stream_socket_client('tcp://localhost:8001')),
  new ReadableResourceStream(fopen('arquivo.txt', 'r')),
  new ReadableResourceStream(fopen('arquivo2.txt', 'r')),
];

$loop = Factory::create();

// $stream = new ReadableResourceStream(fopen('arquivo.txt', 'r'), $loop);

// $readableStreamList = array_map(
  //   fn ($stream) => new ReadableResourceStream($stream, $loop),
  //   $streamList
  // );
  
$http = new DuplexResourceStream(stream_socket_client('tcp://localhost:8080'));
$http->write('GET /http-server.php HTTP/1.1' . "\r\n\r\n");
$http->on('data', function(string $data) {
  $posicaoFimHttp = strpos($data, "\r\n\r\n");
  echo substr($data, $posicaoFimHttp + 4) . "\r\n\r\n";
});

foreach ($streamList as $readableStream) {
  $readableStream->on('data', function(string $data) {
    echo $data;
  });
}

$loop->run();
