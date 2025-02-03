<div class="my-8 grid lg:grid-cols-[400px,1fr] gap-12">
    <div class="flex flex-wrap items-center lg:items-start gap-4 justify-between">
        <div class="grid">
            <h2 class="text-2xl font-bold">{{__('Balance')}}</h2>
            <p class="text-3xl font-bold">
                S/. {{ number_format($balances['total'], 2) }}
            </p>
        </div>
        <div class="grid gap-2 font-semibold">
            <p>Total (PEN) S/. {{number_format($balances['pen'])}}</p>
            <p>Total (USD) $ {{number_format($balances['usd'])}}</p>
            <p>Total (EUR) € {{number_format($balances['eur'])}}</p>
        </div>
    </div>
    <div class="grid">
        <h2 class="text-2xl font-bold">{{__('By Categories')}}</h2>

        <div class="flex items-center gap-2 mt-4">
            <div class="flex-1 text-lg flex items-center">
                <p class="font-semibold">{{__('Category')}}</p>
            </div>
            <p class="w-36 font-semibold">{{__('Expense')}}</p>
            <p class="w-36 font-semibold">{{__('Income')}}</p>
        </div>

        <div class="grid grid-cols-1 gap-4 items-center my-2">
            @foreach($categories as $category)
                <div class="flex items-center gap-2">
                    <div class="flex-1 text-lg flex items-center">
                        {!! $category->icon !!}
                        <p class="font-semibold">{{$category->name}}</p>
                        @if($category->parent)
                            →
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{$category->parent->icon}}{{$category->parent->name}}
                            </p>
                        @endif
                    </div>
                    <p class="w-36 font-semibold">
                        ➖ S/. {{number_format($category->expense)}}
                    </p>
                    <p class="w-36 font-semibold">
                        ➕ S/. {{number_format($category->income)}}
                    </p>
                </div>
            @endforeach
        </div>
    </div>


</div>
