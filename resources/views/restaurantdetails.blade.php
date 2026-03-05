<x-layout>
    <x-slot:title>{{$restaurant->name}}</x-slot:title>
    <x-slot:heading>{{$restaurant->name}}</x-slot:heading>
    <x-slot>
        <div class="restaurant-details">
        <div class="header-section">
            <div class="relative py-12 mb-10 overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-800 via-teal-700 to-blue-900 shadow-2xl text-5xl">
                <h1 class="mb-5"><strong>{{ $restaurant->name }}</strong></h1>
                <p>{{ str_repeat('⭐',5) }}</p>
            </div>
            <p class="text-3xl mb-2">Cím: {{ $restaurant->address }}</p>
            <p>Értékelések száma: {{ count($restaurant->reviews) }}</p>
        </div>

        <div class="button-wrapper">
            <button class="btn-new-review" onclick="beginReviewWriting()">✍️ Új vélemény írása...</button>
        </div>
        <div id="container">

        </div>

        <hr class="separator">

        <div class="comment-wall">
            @foreach ($restaurant->reviews as $review)
            <div class="comment-card">
                <div class="comment-header">
                    <span class="user-name">{{ $review->user->username }}</span>
                    <span class="comment-date">{{ \Carbon\Carbon::parse($review->created_at)->format('Y.m.d H:i') }}</span>
                </div>
                <div class="comment-body">
                    {{ $review->review }}
                </div>
            </div>
            @endforeach
            </div>
        </div>
        <script>
            function beginReviewWriting(){
                let container = document.getElementById('container');
                let htmlContent = `
                <div class="comment-wall">
                <div class="comment-card">
                <form action="review.store" method="POST">
                <textarea name="review" placeholder="Írd le a véleményedet!" class="rounded text-center focus:text-left p-2 w-full h-64"></textarea><br>
                <button type="submit" class="btn-new-review mt-3">Közzététel!</button>
                </form>
                </div>
                </div>
                `;
                container.innerHTML = htmlContent;
            }
        </script>
    </x-slot>
</x-layout>