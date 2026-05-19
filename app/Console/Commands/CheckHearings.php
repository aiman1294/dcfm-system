<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckHearings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-hearings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle()
{
    $targetDate = now()->addDays(3)->toDateString();

    $upcomingCases = \App\Models\CaseFile::whereDate('hearing_date', '=', $targetDate)
        ->get();

    foreach ($upcomingCases as $case) {

        if ($case->user_id) {
            \App\Models\Notification::create([
                'user_id' => $case->user_id,
                'message' => "Your Case #{$case->id} hearing is approaching. Please ensure everything is prepared.",
                'link' => "/cases/{$case->id}",
            ]);
        }

        if ($case->judge_id) {
            \App\Models\Notification::create([
                'user_id' => $case->judge_id,
                'message' => "Case #{$case->id} hearing is approaching.",
                'link' => "/cases/{$case->id}",
            ]);
        }
    }

    $missedNotesCases = \App\Models\CaseFile::whereDate('hearing_date', '<', now()->toDateString())
        ->whereNull('judge_notes')
        ->get();

    foreach ($missedNotesCases as $case) {

        if ($case->judge_id) {
            \App\Models\Notification::create([
                'user_id' => $case->judge_id,
                'message' => "Please add notes for Case #{$case->id}",
                'link' => "/cases/{$case->id}",
            ]);
        }
    }

    $this->info('Hearing notifications checked successfully.');

    return 0;
}
 
    
}
