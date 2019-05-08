<?php

foreach (glob(__DIR__ . '/AdditionalConfiguration/*Configuration.php') as $configFile) {
    include($configFile);
}
