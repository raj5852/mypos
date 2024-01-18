<?php

namespace App\Services;

use App\Models\BankAccount;

class HistoryService
{


    static function Transition($medel, $bankid, $amount, $type = '+', $note, $date = null)
    {
        return   $medel->histories()->create([
            'bank_account_id' => $bankid,
            'amount' => $amount,
            'type' => $type,
            'note' => $note,
            'date' => $date ?: now()
        ]);
    }


}
