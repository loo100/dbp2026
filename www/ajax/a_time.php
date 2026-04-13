<?php
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
  'ok' => true,
  'server_time' => date('Y-m-d H:i:s'),
], JSON_UNESCAPED_UNICODE);
