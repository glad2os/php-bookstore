<?php

use Database\MySQLi;

print json_encode((new MySQLi())->getAuthors());
