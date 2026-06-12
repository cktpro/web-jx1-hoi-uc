<?php
ini_set('session.save_path', '/tmp');
session_start();
echo "Save path: " . session_save_path() . "\n";
echo "Session ID: " . session_id() . "\n";
echo "Session data: "; var_dump($_SESSION);
$_SESSION['test'] = 'works';
echo "Set test=works\n";
