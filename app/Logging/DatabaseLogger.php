<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\DB;
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    protected function write(LogRecord $record): void
    {
        DB::table('logs')->insert([
            'level' => $record->level->getName(),
            'message' => $record->message,
            'context' => json_encode($record->context),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
