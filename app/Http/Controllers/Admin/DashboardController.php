<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Hekmatinasser\Verta\Facades\Verta;

class DashboardController extends Controller
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $month = 12;
        $successTransactions = Transaction::getData($month, 1);
        $successTransactionsChart = $this->chart($successTransactions, $month);

        $failedTransactions = Transaction::getData($month, 0);
        $failedTransactionsChart = $this->chart($failedTransactions, $month);

        return view('admin.dashboard', [
            'successTransactions' => array_values($successTransactionsChart),
            'failedTransactions' => array_values($failedTransactionsChart),
            'monthNames' => array_keys($successTransactionsChart),
            'transactionsCount' => [$successTransactions->count(), $failedTransactions->count()]
        ]);
    }

    private function chart($transactions, $month)
    {
        $monthNames = $transactions->map(function ($item) {
            return verta($item->created_at)->format('%B %y');
        });

        $amounts = $transactions->map(function ($item) {
            return $item->amount;
        });

        $result = [];
        foreach ($monthNames as $i => $monthName){
            $result[$monthName] = ($result[$monthName] ?? 0) + $amounts[$i];
        }

        if (count($result) != $month){
            for ($i = 0; $i < $month; $i++){
                $monthName = verta()->subMonths($i)->format('%B %y');
                $result[$monthName] = ($result[$monthName] ?? 0);
            }
        }

        return sortByShamsiMonthOrder($result);
    }
}
