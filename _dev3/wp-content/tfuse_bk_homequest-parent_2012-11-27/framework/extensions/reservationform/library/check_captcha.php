<?php
session_start();
echo json_encode(strtolower($_SESSION['resform_securityCode']));