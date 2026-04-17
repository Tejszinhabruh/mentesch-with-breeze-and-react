<x-layout>
    <x-slot:title>{{$restaurant->name}}</x-slot:title>
    <x-slot:heading>{{$restaurant->name}}</x-slot:heading>
    <x-slot>
        <div class="restaurant-details">
        <div class="header-section">
            <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl text-5xl text-black dark:text-white">
                <h1 class="mb-5"><strong>{{ $restaurant->name }}</strong></h1>
            </div>
            <p class="text-3xl mb-2 text-black dark:text-white">Cím: {{ $restaurant->address }}</p>
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

        <div class="button-wrapper">
            <button class="btn-new-review text-black dark:text-white" onclick="beginReviewWriting()">✍️ Új vélemény írása...</button>
        </div>
        <div id="container">

        </div>

        <hr class="separator">

        <div class="comment-wall text-black dark:text-white bg-white dark:bg-zinc-950" id="restaurant-comment-wall" data-is-admin="{{ auth()->check() && auth()->user()->is_admin ? 'true' : 'false' }}">
            
        @foreach($restaurant->reviews as $review)
            <div class="comment-card bg-white dark:bg-zinc-950 mb-4 p-4 rounded-lg shadow">
                <div class="comment-header flex justify-between">
                    <span class="user-name font-bold">{{ $review->user->username }}</span>
                    <span class="comment-date text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($review->created_at)->format('Y.m.d H:i') }}
                    </span>
                </div>

                <div class="comment-body text-black dark:text-white my-2">
                    {{ $review->comment }}
                </div>
                <div class="flex items-center justify-center leading-none">
                    @php
                    $star = "★";
                    @endphp
                    <span class="text-yellow-400 text-2xl space-x-0.5">{{ str_repeat($star,$review->rating) }}</span>
                    @if (5-$review->rating!=0)
                    <span class="inline-flex text-gray-300 text-2xl space-x-0.5">{{ str_repeat($star,5-$review->rating) }}</span>
                    @endif
                </div>
                @if(Auth::check() && (Auth::user()->is_admin || Auth::user()->id == $review->user_id))
                    <div class="flex justify-between items-center">
                        <form id="delete-form-{{ $review->id }}" action="/reviews/{{ $review->id }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openDeleteModal({{ $review->id }})" class="p-2 text-red-500 hover:bg-red-500/50 rounded-lg transition-colors border border-red-500">
                                <span class="text-xl">🗑️</span>
                            </button>
                        </form>
                        <form id="update-form-{{ $review->id }}" action="/reviews/{{ $review->id }}" method="PUT" class="inline">
                            @csrf
                            @method('UPDATE')
                            <button type="button" onclick="openUpdateModal({{ $review->id }})" class="p-2 text-emerald-500 hover:bg-emerald-500/50 rounded-lg transition-colors border border-emerald-500">
                                <span class="text-xl">✏️</span>
                            </button>
                        </form>
                    </div>
                @endif

                
            </div>
        @endforeach
            
            </div>
        </div>
    </x-slot>
</x-layout>


<div id="delete-modal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm">
    <div class="isolate bg-white dark:bg-zinc-900 rounded-2xl p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-500/20">
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 dark:bg-emerald-900/30 mb-4">
                <span class="text-3xl">🍃</span>
            </div>
            <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100 mb-2 leading-tight">Biztos vagy benne?</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 text-sm leading-relaxed">Ez a művelet nem vonható vissza. Az értékelésed véglegesen törlődik.</p>
            
            <div class="flex gap-3 mt-4">
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-4 py-2.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 rounded-xl hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors font-semibold text-sm">
                    Mégse
                </button>
                <button type="button" id="confirm-delete-btn" class="flex-1 px-4 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all font-semibold text-sm">
                    Igen, töröld
                </button>
            </div>
        </div>
    </div>
</div>