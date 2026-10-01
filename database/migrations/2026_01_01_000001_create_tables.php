<?php
return function (PDO $db) {
    $schema = file_get_contents(BASE_PATH . '/database/schema.sql');
    $db->exec($schema);
};
