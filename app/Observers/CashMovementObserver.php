<?php

namespace App\Observers;

use App\Models\CashMovement;
use App\Models\Expense;

class CashMovementObserver
{
    public function created(CashMovement $cashMovement)
    {
        if ($cashMovement->is_recurrent) {
            $cashMovement->createRecurringChildren();
        }
    }

    public function updated(CashMovement $cashMovement)
    {
        if ($cashMovement->wasChanged('is_recurrent')) {
            if ($cashMovement->is_recurrent) {
                $cashMovement->createRecurringChildren();
            } else {
                $cashMovement->children()->delete();
            }
        } elseif ($cashMovement->is_recurrent && ($cashMovement->wasChanged('date') || $cashMovement->wasChanged('recurrent_period'))) {
            $cashMovement->children()->delete();
            $cashMovement->createRecurringChildren();
        }
    }

    public function deleting(CashMovement $cashMovement)
    {
        if ($cashMovement->is_recurrent) {
            $cashMovement->children()->delete();
        }
    }
}
