<x-layout>
    <x-slot:title>{{$restaurant->name}}</x-slot:title>
    <x-slot:heading>{{$restaurant->name}}</x-slot:heading>
    <x-slot>
        <div class="restaurant-details">
        <div class="header-section">
            <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl text-5xl text-black dark:text-white">
                <h1 class="mb-5"><strong>{{ $restaurant->name }}</strong></h1>
            </div>
            <p class="text-3xl mb-2 text-black dark:text-white mt-4">Cím: {{ $restaurant->address }}</p>
            <span>
            <span class="text-black dark:text-white">{{ number_format($restaurant->average_rating,1) }}</span>
            @for($i=1;$i<=5;++$i)
                @if($i<=floor($restaurant->average_rating))
                    <span class="text-yellow-400 text-2xl">★</span>
                
                @elseif($i==ceil($restaurant->average_rating) && ($restaurant->average_rating-floor($restaurant->average_rating) >= 0.1))
                    <span class="text-yellow-400 text-2xl" style="position: relative; display: inline-block;">
                        <span style="position: absolute; overflow: hidden; width: 50%;">★</span>
                        <span class="text-gray-300">★</span>
                    </span>
                
                @else
                <span class="text-gray-300 text-2xl">★</span>
                @endif
            @endfor

            <span class="text-slate-600">({{ count($restaurant->reviews) }} vélemény)</span>
            </span>
            
        </div>
        <div class="mt-4">
            @foreach ($restaurant->allergens as $allergen)
            @if(auth()->user()->allergens->contains('id', $allergen->id))
            <span class="bg-red-900/20 text-red-400 border-red-500/30 px-2 py-1 text-xl font-medium rounded-full transition-colors border">{{ $allergen->name }}</span>
            @else
                <span class="bg-emerald-900/20 text-emerald-400 border-emerald-500/30 px-2 py-1 text-xl font-medium rounded-full transition-colors border">{{ $allergen->name }}</span>
            @endif
            @endforeach
        </div>

        <div class="button-wrapper">
            <button class="btn-new-review text-black dark:text-white" onclick="beginReviewWriting({{ $restaurant->id }}, '{{ csrf_token() }}')">✍️ Új vélemény írása...</button>
        </div>
        <div id="container">

        </div>

        <hr class="separator">

        <div class="comment-wall text-black dark:text-white bg-white dark:bg-zinc-950" id="restaurant-comment-wall">
    
    @foreach($restaurant->reviews as $review)
        <div class="comment-card bg-white dark:bg-zinc-950 mb-4 p-6 rounded-lg shadow-md border border-gray-100 dark:border-zinc-800">
            <div class="comment-header flex justify-between items-start mb-2">
                <span class="user-name font-bold text-emerald-600">{{ $review->user->username }}</span>
                <span class="comment-date text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($review->created_at)->format('Y.m.d H:i') }}
                </span>
            </div>

            <div class="comment-body text-black dark:text-white my-4 text-center">
                {{ $review->comment }}
            </div>

            <div class="flex items-center justify-center mb-4">
                @php $star = "★"; @endphp
                <span class="text-yellow-400 text-2xl">{{ str_repeat($star, $review->rating) }}</span>
                @if (5 - $review->rating > 0)
                    <span class="text-gray-300 text-2xl">{{ str_repeat($star, 5 - $review->rating) }}</span>
                @endif
            </div>

            @if(Auth::check() && (Auth::user()->is_admin || Auth::user()->id == $review->user_id))
                <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-100 dark:border-zinc-800">
                    <form id="delete-form-{{ $review->id }}" action="/reviews/{{ $review->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openDeleteModal({{ $review->id }})" class="p-2 text-red-500 hover:bg-red-500/50 rounded-lg transition-colors border border-red-500">
                                <span class="text-xl">🗑️</span>
                            </button>
                        </form>
                    
                    <button type="button" onclick="beginReviewWriting({{ $restaurant->id }}, '{{ csrf_token() }}', {{ $review->id }}, '{{ addslashes($review->comment) }}', {{ $review->rating }})" class="p-2 text-emerald-500 hover:bg-emerald-500/10 rounded-lg transition-colors border border-emerald-500/50">
                        <span class="text-xl">✏️</span>
                    </button>
                </div>
            @endif
        </div>
    @endforeach

            </div>
        </div>
    </x-slot>
</x-layout>