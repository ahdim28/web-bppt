<div>
    <div class="px-4 space-y-4 mt-8">
        <form action="{{ route('search') }}" method="get">
            <input class="border-solid border border-gray-300 p-2 w-full md:w-1/4" name="keyword"
                type="text" placeholder="Keywords" wire:model="search"/>
                <button type="submit">search</button>
        </form>
        <div wire:loading>Searching...</div>
        <div wire:loading.remove>
        <!-- 
            notice that $term is available as a public 
            variable, even though it's not part of the 
            data array 
        -->
        @if ($search == "")
            <div class="text-gray-500 text-sm">
                Enter a term to search for content.
            </div>
        @else
            @if($data['post']->isEmpty())
                <div class="text-gray-500 text-sm">
                    No matching result was found.
                </div>
            @else
                @foreach($data['post'] as $item)
                    <div>
                        <h3 class="text-lg text-gray-900 text-bold">{{$item->fieldLang('title')}}</h3>
                        <p class="text-gray-500 text-sm">{{$item->created_at}}</p>
                        <p class="text-gray-500">{{$item->updated_at}}</p>
                    </div>
                @endforeach
            @endif
        @endif
        </div>
    </div>
</div>