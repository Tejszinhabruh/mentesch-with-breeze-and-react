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

function showStatusMessage(message, type = 'success') {
    const container = document.getElementById('status-message-container');
    if (!container) return;

    const toast = document.createElement('div');
    
    const bgClass = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
    
    toast.className = `
        ${bgClass} text-black dark:text-white px-6 py-3 rounded-xl shadow-lg 
        transition-all duration-500 transform translate-y-[-20px] opacity-0
        flex items-center justify-between pointer-events-auto
    `;
    
    toast.innerHTML = `
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 hover:scale-110 transition-transform">✕</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.classList.remove('translate-y-[-20px]', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');
    }, 10);

    setTimeout(() => {
        toast.classList.remove('translate-y-0', 'opacity-100');
        toast.classList.add('translate-y-[-20px]', 'opacity-0');
        setTimeout(() => toast.remove(), 500);
    }, 3000);
}

window.deleteAllergen = async function(id) {
    if (!confirm('Biztosan törölni szeretnéd ezt az allergént?')) return;

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
        const response = await fetch(`/api/allergens/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            showStatusMessage('Sikeres törlés!', 'success');

            const card = document.getElementById(`allergen-card-${id}`);
            if (card) {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9) translateY(20px)';
                setTimeout(() => card.remove(), 500);
            }
        } else {
            showStatusMessage('Hiba történt a törlés során.', 'error');
        }
    } catch (error) {
        showStatusMessage('Hálózati hiba történt.', 'error');
    }
};

async function renderAllergens() {
    const container = document.getElementById('allergens-container');
    if (!container) return;

    const isAdmin = container.getAttribute('data-is-admin') === 'true';
    const allergens = await fetchAllergens();

    const htmlContent = allergens.map(allergen => {
        const { text: textColor, hover: hoverColor } = getAllergenColors(allergen.name);
        const cardId = `allergen-card-${allergen.id}`;

        return `
            <div id="${cardId}" class="bg-gray-200 dark:bg-zinc-900 border border-black/2 dark:border-white/10 rounded-xl p-6 flex flex-col transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-[0_0_15px_rgba(52,211,153,0.15)] group">
            
            ${isAdmin ? `
            <div class="text-right">
                <button onclick="deleteAllergen(${allergen.id})" class="text-xl p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white border border-red-500/50 rounded-lg transition-all">
                    🗑️
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