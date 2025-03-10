<div class="w-full py-4 px-2 gap-4 rounded-md shadow-lg bg-slate-700 border-l-4"
     style="border-color: {{ $account->color }}">
    <div class="flex flex-row justify-between items-center gap-2">
        <span
            class="flex items-center gap-1 text-sm font-medium text-white">
                {{ $account->icon }} {{ $account->name }}
            </span>

        <span class="text-sm font-medium text-white">
                {{ $account->currency->symbol }} {{ number_format($account->current_balance, 2) }}
            </span>
    </div>
    <div class="flex justify-end">
        <span class="text-xs font-medium text-slate-300">
                Starting Balance:
                {{ $account->currency->symbol }} {{ number_format($account->starting_balance, 2) }}
            </span>
    </div>
</div>




