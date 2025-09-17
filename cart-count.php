<?php
session_start();
header('Content-Type: application/json');
echo json_encode(['count' => array_sum(array_column($_SESSION['cart'], 'qty'))]);
