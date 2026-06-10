<?php

/**
 * Point d'entrée racine — délègue au front controller CI4 (public/).
 * Les anciennes URLs .php sont redirigées via .htaccess vers les routes CI4.
 */
chdir(__DIR__ . '/public');
require __DIR__ . '/public/index.php';
