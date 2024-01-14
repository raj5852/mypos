<?php

namespace App\Services;

use App\Models\BankAccount;

class HistoryService
{
    static function BankHistory($bank_id, $owner_id = null, $amount, $type = '+', $note,$date = null)
    {
        $bank =   BankAccount::findOrFail($bank_id);

        $bank->histories()
            ->create([
                'owner_id' => $owner_id,
                'amount' => $amount,
                'type' => $type,
                'note' => $note,
                'date' => $date ?: now()
            ]);
        if ($type == '+') {
            $bank->increment('current_balance', $amount);
        } else {
            $bank->decrement('current_balance', $amount);
        }

        return $bank;
    }
}
