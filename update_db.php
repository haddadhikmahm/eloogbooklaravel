<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Kanban Boards: \n";
print_r(App\Models\KanbanBoard::pluck('name')->toArray());

echo "Kanban Tasks Status: \n";
print_r(App\Models\KanbanTask::pluck('status')->unique()->toArray());

echo "Kanban Tasks Priority: \n";
print_r(App\Models\KanbanTask::pluck('priority')->unique()->toArray());
