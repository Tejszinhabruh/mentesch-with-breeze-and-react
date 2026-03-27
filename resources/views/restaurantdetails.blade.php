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
            <p class="text-black dark:text-white">Értékelések száma: {{ count($restaurant->reviews) }}</p>
        </div>

        <div class="button-wrapper">
            <button class="btn-new-review text-black dark:text-white" onclick="beginReviewWriting()">✍️ Új vélemény írása...</button>
        </div>
        <div id="container">

        </div>

        <hr class="separator">

        <div class="comment-wall text-black dark:text-white bg-white dark:bg-zinc-950">
            @foreach ($restaurant->reviews as $review)
            <div class="comment-card bg-white dark:bg-zinc-950">
                <div class="comment-header">
                    <span class="user-name">{{ $review->user->username }}</span>
                    <span class="comment-date">{{ \Carbon\Carbon::parse($review->created_at)->format('Y.m.d H:i') }}</span>
                </div>
                <div class="comment-body text-black dark:text-white">
                    {{ $review->review }}
                </div>
                @if(Auth::user()->is_admin || Auth::user()->id == $review->user_id)
                        <div class="text-right">
                            <button class="bg-red-600 text-2xl rounded border border-red-700">🗑️</button>
                        </div>
                @endif
            </div>
            @endforeach
            </div>
        </div>
    </x-slot>
</x-layout>