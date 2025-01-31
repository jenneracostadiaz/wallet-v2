<?php

namespace App\Livewire\Records;

use App\Models\Currency;
use App\Models\Record;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public bool $modal = false;
    public string $selectType = 'expense';
    public ?int $from_account;
    public int $from_amount;
    public int $from_currency;
    public ?int $to_account;
    public int $to_amount;
    public int $to_currency;
    public ?int $category;
    public ?int $label;
    public $date;
    public $time;

    public function resetFields(): void
    {
        $this->from_account = auth()->user()->accounts->first()->id ?? null;
        $this->from_amount = 0;
        $this->from_currency = 1;
        $this->to_account = auth()->user()->accounts->first()->id ?? null;
        $this->to_amount = 0;
        $this->to_currency = 1;
        $this->category = auth()->user()->categories->first()->id ?? null;
        $this->label = auth()->user()->labels->first()->id ?? null;
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');
    }

    public function openModal(): void
    {
        $this->modal = true;
        $this->resetFields();
    }

    public function closeModal(): void
    {
        $this->modal = false;
        $this->resetFields();
    }

    public function setType(string $type): void
    {
        $this->selectType = $type;
    }

    public function save(): void
    {
//        dd($this->from_account, $this->from_amount, $this->from_currency, $this->to_account, $this->to_amount, $this->to_currency, $this->category, $this->label, $this->date, $this->time);
        DB::beginTransaction();
        try {
            auth()->user()->records()->create([
                'type' => $this->selectType,
                'account_id' => $this->to_account,
                'amount' => $this->to_amount,
                'currency_id' => $this->to_currency,
                'category_id' => $this->category,
                'label_id' => $this->label,
                'date' => $this->date,
                'time' => $this->time,
            ]);
            $this->closeModal();
            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('error', 'Something went wrong');
        }
    }

    public function mount(): void
    {
        $this->from_account = auth()->user()->accounts->first()->id ?? null;
        $this->to_account = auth()->user()->accounts->first()->id ?? null;
        $this->category = auth()->user()->categories->first()->id ?? null;
        $this->label = auth()->user()->labels->first()->id ?? null;
        $this->date = now()->format('Y-m-d');
        $this->time = now()->format('H:i');
    }

    public function render(): View
    {
        return view('livewire.records.create', [
            'types' => ['expense', 'income', 'transfer'],
            'accounts' => auth()->user()->accounts,
            'currencies' => Currency::all(),
            'categories' => auth()->user()->categories->where('parent_id', null),
            'labels' => auth()->user()->labels,
        ]);
    }
}
