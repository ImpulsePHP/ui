<?php
require __DIR__ . '/../core/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';
$c = new \Impulse\UI\Component\Interface\UIDataTableComponent('t', null, [
    'columns' => [['key' => 'name', 'label' => 'Name'], ['key' => 'role', 'label' => 'Role']],
    'rows' => [['name' => 'Alice', 'role' => 'Admin'], ['name' => 'Bob', 'role' => 'Editor']],
    'sortBy' => 'name',
    'sortDirection' => 'asc',
]);
echo $c->template();

