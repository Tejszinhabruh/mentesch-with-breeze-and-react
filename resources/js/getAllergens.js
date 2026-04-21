function getAllergenColors(name) {
    const colors = {
        'Glutén': { text: 'text-amber-300', hover: 'group-hover:text-amber-400' },
        'Mustár': { text: 'text-amber-300', hover: 'group-hover:text-amber-400' },
        'Szezámmag': { text: 'text-amber-300', hover: 'group-hover:text-amber-400' },
        'Szója': { text: 'text-amber-300', hover: 'group-hover:text-amber-400' },
        'Hal': { text: 'text-blue-500', hover: 'group-hover:text-blue-600' },
        'Laktóz': { text: 'text-blue-500', hover: 'group-hover:text-blue-600' },
        'Zeller': { text: 'text-lime-400', hover: 'group-hover:text-lime-500' },
        'Mogyoró': { text: 'text-lime-400', hover: 'group-hover:text-lime-500' },
        'Tojás': { text: 'text-slate-300', hover: 'group-hover:text-slate-400' }
    };

    return colors[name] || { text: 'text-red-400', hover: 'group-hover:text-red-500' };
}

async function fetchAllergens() {
    try {
        const response = await fetch('/api/allergens');
        if (!response.ok) {
            throw new Error(`Hálózati hiba történt: ${response.status}`);
        }
        const responseData = await response.json();
        return Array.isArray(responseData) ? responseData : (responseData.data || []);
    } catch (error) {
        console.error('Hiba az allergének lekérdezésekor:', error);
        return [];    
    }
}

async function renderAllergens() {
    const container = document.getElementById('allergens-container');
    if (!container) return;

    const isAdmin = container.getAttribute('data-is-admin') === 'true';
    const allergens = await fetchAllergens();

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const htmlContent = allergens.map(allergen => {
        const { text: textColor, hover: hoverColor } = getAllergenColors(allergen.name);
        const cardId = `allergen-card-${allergen.id}`;

        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        return `
            <div id="${cardId}" class="bg-gray-200 dark:bg-zinc-900 border border-black/2 dark:border-white/10 rounded-xl p-6 flex flex-col transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-[0_0_15px_rgba(52,211,153,0.15)] group">
            
            ${isAdmin ? `
            <div class="text-right">
                <form id="delete-form-${allergen.id}" action="/allergens/${allergen.id}" method="POST" class="inline">
                    <input type="hidden" name="_token" value="${token}">
                    <input type="hidden" name="_method" value="DELETE">
                </form>
                <button type="button" onclick="openDeleteModal(${allergen.id})" class="p-2 text-red-500 hover:bg-red-500/50 rounded-lg transition-colors border border-red-500">
                        <span class="text-xl">🗑️</span>
                    </button>
            </div>
            ` : ''}
            
            <h3 class="text-2xl font-bold ${textColor} mb-4 ${hoverColor} transition-colors">
                ${allergen.name}
            </h3>

            <div class="mt-auto pt-4 border-t border-gray-700/50">
                <p class="dark:text-gray-300 text-gray-500 mb-4">
                    ${allergen.desc}
                </p>
            </div>

            <div class="mt-auto pt-4 border-t border-gray-700/50">
                <p class="text-sm font-semibold text-gray-400 mb-2 italic">Helyettesítők:</p>
                <h3 class="text-xl font-bold mb-4 transition-colors">
                    ${allergen.replist}
                </h3>
            </div>
            </div>
        `;
    }).join('');
    container.innerHTML = htmlContent;
}

window.getAllergens = renderAllergens;

if (document.readyState === 'complete' || document.readyState === 'interactive') {
    renderAllergens();
} else {
    document.addEventListener('DOMContentLoaded', renderAllergens);
}