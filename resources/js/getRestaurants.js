async function fetchRestaurants() {
    const response = await fetch('/api/restaurants');
    if (!response.ok) {
        throw new Error(`Hálózati hiba történt: ${response.status}`);
    }
    const responseData = await response.json();
    return responseData.data;
}

function filterRestaurants(restaurants, searchWord) {
    if (!searchWord) return restaurants;
    
    const lowerCaseSearchWord = searchWord.toLowerCase();
    return restaurants.filter(restaurant => 
        restaurant.name.toLowerCase().includes(lowerCaseSearchWord)
    );
}

function createRestaurantCard(restaurant, isAdmin) {
    const cardId = `restaurant-card-${restaurant.id}`;
    
    const adminHtml = isAdmin ? `
        <div class="absolute top-2 right-2 z-10">
            <button onclick="deleteRestaurant(${restaurant.id})" class="p-2 bg-red-900/30 hover:bg-red-500 text-red-500 hover:text-white rounded-md transition-all border border-red-500/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    ` : '';

    const reviewCount = restaurant.reviews ? restaurant.reviews.length : 0;

    return `
        <div id="${cardId}" class="group bg-gray-400 dark:bg-[#24221f] border border-[#3b3834] rounded-2xl overflow-hidden shadow-lg hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-emerald-900/20 transition-all duration-300 flex flex-col relative">
            <div class="p-6 flex-grow text-center">
                ${adminHtml}
                <div class="w-16 h-16 bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🍽️</span>
                </div>
                <h3 class="text-2xl font-bold mb-2 group-hover:text-emerald-400 transition-colors">
                    ${restaurant.name}
                </h3>
                <div class="flex items-center justify-center gap-2 mb-6">
                    <span class="text-emerald-500">📝</span>
                    <span>${reviewCount} vélemény</span>
                </div>
            </div>
            <div class="p-4 bg-gray-500 dark:bg-[#1c1a17] border-t border-[#3b3834]">
                <a href="/restaurants/${restaurant.id}" class="block w-full text-center py-3 rounded-xl bg-transparent border border-emerald-500/30 text-emerald-400 font-semibold hover:bg-emerald-500 hover:text-black transition-all duration-300">
                    Részletek megtekintése
                </a>
            </div>
        </div>
    `;
}

async function handleSearch() {
    const searchInput = document.getElementById('search');
    const container = document.getElementById('restaurantsContainer');

    if (!container || !searchInput) return;

    const searchWord = searchInput.value;
    const isAdmin = container.getAttribute('data-is-admin') === 'true';

    try {
        const allRestaurants = await fetchRestaurants();
        const filteredRestaurants = filterRestaurants(allRestaurants, searchWord);
        if (filteredRestaurants.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-400 mt-4">Nincs a keresésnek megfelelő étterem 🥲...</p>';
            return;
        }

             container.innerHTML = filteredRestaurants
            .map(restaurant => createRestaurantCard(restaurant, isAdmin))
            .join('');

    } catch (error) {
        console.error('Hiba történt az éttermek lekérésekor:', error);
        container.innerHTML = '<p class="text-center text-red-500 mt-4">Hiba történt az adatok betöltése során. Kérjük, próbálja újra később!</p>';
    }
}

window.searchRestaurant = handleSearch;

window.deleteRestaurant = async function(id) {
    if (!confirm('Biztosan törölni szeretnéd ezt az éttermet és az összes hozzá tartozó adatot?')) return;

    try {
        const response = await fetch(`/api/restaurants/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (response.ok) {
            const card = document.getElementById(`restaurant-card-${id}`);
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => card.remove(), 300);
            }
        } else {
            const errorData = await response.json();
            alert('Hiba: ' + (errorData.message || 'Nem sikerült a törlés.'));
        }
    } catch (error) {
        console.error('Hiba a törlés során:', error);
        alert('Hálózati hiba történt a törléskor.');
    }
};