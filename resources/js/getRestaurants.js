let container = document.getElementById('restaurantsContainer');

if (container) {
    const isAdmin = container.getAttribute('data-is-admin') === 'true';
    fetch('/api/restaurants')
        .then(response => {
            if (!response.ok) throw new Error('Hálózati hiba történt!');
            return response.json(); 
        })
        .then(responseData => {
            const restaurants = responseData.data;

            container.innerHTML = restaurants.map(r => `
                <div class="group bg-gray-400 dark:bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-emerald-900/20 transition-all duration-300 flex flex-col">
                    <div class="p-6 flex-grow text-center">
                        ${isAdmin ? `
                            <div class="text-right">
                                <button class="bg-red-600 text-2xl rounded border border-red-700">🗑️</button>
                            </div>
                        ` : ''}
                        <div class="w-16 h-16 bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            <span class="text-3xl">🍽️</span>
                        </div>

                        <h3 class="text-2xl font-bold mb-2 group-hover:text-emerald-400 transition-colors">
                            ${r.name}
                        </h3>

                        <div class="flex items-center justify-center gap-2-400 mb-6">
                            <span class="text-emerald-500">★</span>
                            <span>${r.reviews ? r.reviews.length : 0} vélemény</span>
                        </div>
                    </div>
        
                    <div class="p-4 bg-gray-500 dark:bg-[#1c1a17] border-t border-[#3b3834]">
                        <a href="/restaurants/${r.id}" class="block w-full text-center py-3 rounded-xl bg-transparent border border-emerald-500/30 text-emerald-400 font-semibold hover:bg-emerald-500 hover:text-black transition-all duration-300">
                            Részletek megtekintése
                        </a>
                    </div>
                </div>
            `).join('');
        })
        .catch(error => console.error('Hiba történt:', error));
}