<?php

namespace App\Console\Commands;

use App\Models\LogsModel;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;
use Storage;

class LimpaLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:limpar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleta logs com mais de 30 dias.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            LogsModel::where('created_at', '<', Carbon::now()->subDays(30))->delete();
    
            $this->info('Logs limpo com sucesso.');
            Log::channel('clean_logs')->info('Logs limpo com sucesso.');
        } catch (\Throwable $th) {
            Log::channel('clean_logs')->error('Erro ao limpar logs: ' . $th->getMessage());
            $this->error('Erro ao limpar logs.');
        }
    }
}
