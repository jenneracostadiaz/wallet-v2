@props(['payment', 'actions' => true])
<div
    class="w-full py-4 px-4 rounded-md shadow-lg bg-slate-700 {{ \Carbon\Carbon::parse($payment->payment_date)->between(now()->startOfMonth(), now()->addWeeks(3)) ? 'opacity-100' : 'opacity-60' }}">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 items-center">
        <div class="flex flex-col gap-1">
            <span
                class="flex items-center gap-1 text-sm font-medium text-white">
                {{ $payment->payment_description }}
            </span>
            <span class="text-xs font-medium text-slate-300">
                {{__('Dues')}}: {{ $payment->total_installments }} → {{__('Total payment')}}: S/.{{ number_format($payment->total_amount, 2) }}
            </span>
            <span class="text-xs font-medium text-slate-300">
                {{__('Payment date')}}: {{ $payment->payment_date }}
            </span>
        </div>
        <div class="flex-1 flex flex-col gap-1">
            <span class="text-sm font-medium text-white">
                {{__('Pay now')}}: S/.{{ number_format($payment->installment_amount, 2) }}
            </span>
            <span class="text-xs font-medium text-slate-300">
                {{__('Remaining payable')}}: S/.{{ number_format($payment->remaining_amount, 2) }}
            </span>
        </div>
        <div class="flex justify-end items-end gap-2">
            @if($actions)
                <button
                    wire:click="pay({{$payment->id}})"
                    class="flex justify-center items-center py-2.5 px-3 gap-1 text-sm font-medium">
                    ✅
                </button>
                <button
                    wire:click="openModal({{$payment->id}})"
                    class="flex justify-center items-center py-2.5 px-3 gap-1 text-sm font-medium text-white text-center ">
                    ✏️
                </button>
                <div class="relative">
                    <button type="button" wire:click="delete({{$payment->id}})"
                            wire:confirm.prompt="Are you sure?\n\nType DELETE to confirm|DELETE"
                            class="flex justify-center items-center py-2.5 px-1 text-sm font-medium text-white text-center">
                        🗑️
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
