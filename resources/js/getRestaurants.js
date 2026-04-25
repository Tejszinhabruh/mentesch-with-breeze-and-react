async function fetchRestaurants(url = '/api/restaurants') {
    const response = await fetch(url);
    if (!response.ok) {
        throw new Error(`Hálózati hiba történt: ${response.status}`);
    }
    const responseData = await response.json();
    return responseData;
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

    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    const adminHtml = isAdmin ? `
        <div class="absolute top-2 right-2 z-10">
            <form id="delete-form-${restaurant.id}" action="/restaurants/${restaurant.id}" method="POST" class="inline">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="hidden" name="_method" value="DELETE">
            </form>
            <button type="button" onclick="openDeleteModal(${restaurant.id})" class="p-2 text-red-500 hover:bg-red-500/50 rounded-lg transition-colors border border-red-500">
                <span class="text-xl">🗑️</span>
            </button>
        </div>
    ` : '';

    const reviewCount = restaurant.reviews ? restaurant.reviews.length : 0;
    let allergensHtml = '';
    if (restaurant.allergens && restaurant.allergens.length > 0) {
        const userAllergenIds = window.userAllergens.map(id => Number(id));

        const sortedAllergens = [...restaurant.allergens].sort((a, b) => {
            const aMatch = userAllergenIds.includes(Number(a.id)) ? 1 : 0;
            const bMatch = userAllergenIds.includes(Number(b.id)) ? 1 : 0;
            return bMatch - aMatch; 
        });

        allergensHtml = `
            <div class="flex flex-wrap justify-center gap-2 mt-4">
                ${sortedAllergens.map(allergen => {
                    const isMatched = userAllergenIds.includes(Number(allergen.id)); 
                    
                    const bgClass = isMatched ? 'bg-red-900/60' : 'bg-emerald-900/20';
                    const textClass = isMatched ? 'text-red-200' : 'text-emerald-400';
                    const borderClass = isMatched ? 'border-red-500' : 'border-emerald-500/30';
                    const fontWeight = isMatched ? 'font-black' : 'font-medium';

                    return `
                        <span class="px-2 py-1 text-xs ${fontWeight} ${bgClass} ${textClass} border ${borderClass} rounded-full transition-all">
                            ${allergen.name}
                        </span>
                    `;
                }).join('')}
            </div>
        `;
        
    }

    return `
        <div id="${cardId}" class="group bg-gray-400 dark:bg-[#24221f] border border-black/2 dark:border-white/10 rounded-2xl overflow-hidden shadow-lg hover:-translate-y-2 hover:border-emerald-500/50 hover:shadow-emerald-900/20 transition-all duration-300 flex flex-col relative">
            <div class="p-6 flex-grow text-center">
                ${adminHtml}
                <div class="w-16 h-16 bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                    <span class="text-3xl">🍽️</span>
                </div>
                <h3 class="text-2xl font-bold mb-2 group-hover:text-emerald-400 transition-colors">
                    ${restaurant.name}
                </h3>
                <div class="flex items-center justify-center gap-2 pb-3 mb-auto border-b border-gray-700/50 mb-4">
                    <span class="text-emerald-500">📝</span>
                    <span>${reviewCount} vélemény</span>
                </div>
                ${allergensHtml}
            </div>
            <div class="p-4 bg-gray-500 dark:bg-[#1c1a17] border-t border-[#3b3834]">
                <a href="/restaurants/${restaurant.id}" class="block w-full text-center py-3 rounded-xl bg-transparent border border-emerald-500/30 text-emerald-400 font-semibold hover:bg-emerald-500 hover:text-black transition-all duration-300">
                    Részletek megtekintése
                </a>
            </div>
        </div>
    `;
}

function renderPagination(restaurants){
    const pagination = document.getElementById('pagination-links');
    pagination.innerHTML = '';

    restaurants.links.forEach(restaurant => {
        const button = document.createElement('button');
        button.disabled = !restaurant.url || restaurant.active;

        button.classList = "px-3 py-1 m-1 rounded border text-black dark:text-white bg-emerald-500";
        let label = restaurant.label;
        if (label.includes('Previous')) {
            label = '« Előző';
        } else if (label.includes('Next')) {
            label = 'Következő »';
        }

        button.innerHTML = label;

        if(restaurant.active){
            button.style.fontWeight = 'bold';
        }

        button.addEventListener('click',()=>{
            if(restaurant.url){
                handleSearch(restaurant.url);
                window.scrollTo({top: 0, behavior: 'smooth'});
            }
        });
        pagination.appendChild(button);
    });
}


async function handleSearch(url = '/api/restaurants') {
    if (url instanceof Event || typeof url !== 'string') {
        url = '/api/restaurants';
    }

    const searchInput = document.getElementById('search');
    const container = document.getElementById('restaurantsContainer');

    if (!container || !searchInput) return;

    const searchWord = searchInput ? searchInput.value : '';
    const isAdmin = container.getAttribute('data-is-admin') === 'true';

    try {
        const allRestaurants = await fetchRestaurants(url);
        const filteredRestaurants = filterRestaurants(allRestaurants.data, searchWord);
        if (filteredRestaurants.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-400 mt-4">Nincs a keresésnek megfelelő étterem 🥲...</p>';
            document.getElementById('pagination-links').innerHTML = '';
            return;
        }
        const userAllergenIds = window.userAllergens.map(id => Number(id));

        filteredRestaurants.sort((a, b) => {
            const aHasMatch = a.allergens.some(allg => userAllergenIds.includes(Number(allg.id))) ? 1 : 0;
            const bHasMatch = b.allergens.some(allg => userAllergenIds.includes(Number(allg.id))) ? 1 : 0;

            return bHasMatch - aHasMatch;
        });

             container.innerHTML = filteredRestaurants
            .map(restaurant => createRestaurantCard(restaurant, isAdmin))
            .join('');
            renderPagination(allRestaurants);

    } catch (error) {
        console.error('Hiba történt az éttermek lekérésekor:', error);
    }
}

window.onload = () => handleSearch();

window.searchRestaurant = handleSearch;