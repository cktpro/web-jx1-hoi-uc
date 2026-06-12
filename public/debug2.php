<?php
ini_set('session.save_path', '/tmp');
session_start();
echo json_encode([
    'session_id' => session_id(),
    'save_path' => session_save_path(),
    'session_data' => $_SESSION,
    'cookie' => $_COOKIE,
]);
