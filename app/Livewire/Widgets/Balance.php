<?php

namespace App\Livewire\Widgets;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Balance extends Component
{
    #[On('refreshRecords')]
    public function refreshRecords(): void
    {
        $this->render();
    }

    public function render(): View
    {

        return view('livewire.widgets.balance', [
            'balances' => $this->getBalances()['balances'],
            'categories' => $this->getBalances()['categories'],
        ]);
    }

    private function getBalances(): array
    {
        $accounts = auth()->user()->accounts;
        $balances = [
            'total' => 0,
            'payments' => 0,
            'difference' => 0,
            'pen' => 0,
            'usd' => 0,
            'eur' => 0,
        ];
        $exchangeRates = [
            'USD' => 3.72,
            'EUR' => 3.86,
        ];

        foreach ($accounts as $account) {
            $currencyCode = strtolower($account->currency->code);
            $currentBalance = $account->current_balance;

            if (isset($balances[$currencyCode])) {
                $balances[$currencyCode] += $currentBalance;
                $balances['total'] += $currencyCode === 'pen' ? $currentBalance : $currentBalance * $exchangeRates[strtoupper($currencyCode)];
            }
        }

        $balances['payments'] = auth()->user()->payments()->sum('installment_amount');

        $balances['difference'] = $balances['total'] - $balances['payments'];

        $categories = auth()->user()->categories()
            ->whereNotNull('parent_id')
            ->with(['records' => function ($query) {
                $query->select('category_id', 'type', DB::raw('SUM(amount) as total'))
                    ->groupBy('category_id', 'type');
            }])
            ->get()
            ->map(function ($category) {
                $found = $category->records->groupBy('type')->map(function ($records) {
                    return $records->sum('total');
                })->toArray();
                $category->expense = $found['expense'] ?? 0;
                $category->income = $found['income'] ?? 0;
                return $category;
            })
            ->sortByDesc('expense')
            ->take(5);

        return [
            'balances' => $balances,
            'categories' => $categories,
        ];
    }
}
