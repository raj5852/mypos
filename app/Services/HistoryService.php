<?php

namespace App\Services;

use App\Models\BankAccount;

class HistoryService
{
    // static function BankHistory($bank_id, $owner_id = null, $amount, $type = '+', $note, $date = null, $purchase_payment_id = null)
    // {
    //     $bank = BankAccount::findOrFail($bank_id);

    //     if ($amount != 0) {
    //         $bank->histories()
    //             ->create([
    //                 'owner_id' => $owner_id,
    //                 'purchase_payment_id' => $purchase_payment_id,
    //                 'amount' => $amount,
    //                 'type' => $type,
    //                 'note' => $note,
    //                 'date' => $date ?: now()
    //             ]);
    //         if ($type == '+') {
    //             $bank->increment('current_balance', $amount);
    //         } else {
    //             $bank->decrement('current_balance', $amount);
    //         }
    //     }

    //     return $bank;
    // }

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
