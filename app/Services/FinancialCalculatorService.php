<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Setting;
use App\Models\Earning;
use App\Models\Payout;
use Illuminate\Support\Facades\DB;

class FinancialCalculatorService
{
    /**
     * Calculate the breakdown of earnings without saving.
     */
    public function calculateBreakdown(int $projectId, float $totalAmount): ?array
    {
        $project = Project::with('members.user')->find($projectId);
        
        if (!$project) {
            return null;
        }

        // 1. Get Global Backup Percentage
        $backupPercent = (float) Setting::where('key', 'backup_percentage')->value('value') ?? 10;
        
        // 2. Calculate Base Splits
        $gross = $totalAmount;
        $backupAmount = ($gross * $backupPercent) / 100;
        $distributable = $gross - $backupAmount;

        $payouts = [];

        foreach ($project->members as $member) {
            $sharePercent = (float) $member->contribution_share;
            // dd($sharePercent);
            // Calculate Member Share based on DISTRIBUTABLE amount
            $amount = ($distributable * $sharePercent) / 100;

            $payouts[] = [
                'user_id' => $member->user_id, // Store ID directly for easier saving later
                'name' => $member->user->name,
                'role' => $member->role,
                'share_percent' => $sharePercent,
                'amount' => $amount
            ];
        }

        return [
            'gross' => $gross,
            'backup_percent' => $backupPercent,
            'backup_amount' => $backupAmount,
            'distributable' => $distributable,
            'payouts' => $payouts
        ];
    }

    /**
     * Save the earning and generate payout records.
     */
    public function recordEarning(int $projectId, string $date, float $amount): void
    {
        $breakdown = $this->calculateBreakdown($projectId, $amount);

        if (!$breakdown) {
            return;
        }

        DB::transaction(function () use ($projectId, $date, $breakdown) {
            // 1. Create Earning Record
            $earning = Earning::create([
                'project_id' => $projectId,
                'earning_date' => $date,
                'total_amount' => $breakdown['gross'],
                'backup_amount' => $breakdown['backup_amount'],
                'distributable_amount' => $breakdown['distributable'],
            ]);

            // 2. Create Payout Records
            foreach ($breakdown['payouts'] as $payoutData) {
                Payout::create([
                    'earning_id' => $earning->id,
                    'user_id' => $payoutData['user_id'],
                    'role_at_time' => $payoutData['role'],
                    'percentage_applied' => $payoutData['share_percent'],
                    'amount' => $payoutData['amount'],
                    'is_paid' => false, // Default
                ]);
            }
        });
    }
}