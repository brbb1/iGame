<?php
declare(strict_types=1);

echo "<pre>" . print_r($_SERVER, true) . "</pre>";
echo "<pre>" . print_r($_REQUEST, true) . "</pre>";
echo file_get_contents('php://input');