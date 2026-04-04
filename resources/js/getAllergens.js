const container = document.getElementById('allergens-container');
if(container){
    const isAdmin = container.getAttribute('data-is-admin') === 'true';
    fetch('/api/allergens')
            .then(response => response.json())
            .then(data => {
                let htmlContent = '';

            data.forEach(allergen => { 
                let textColor = '';
                let hoverColor = '';

                if (['Glutén', 'Mustár', 'Szezámmag', 'Szója'].includes(allergen.name)) {
                    textColor = 'text-amber-300';
                    hoverColor = 'group-hover:text-amber-400';
                } 
                else if (['Hal', 'Laktóz'].includes(allergen.name)) {
                    textColor = 'text-blue-500';
                    hoverColor = 'group-hover:text-blue-600';
                } 
                else if (['Zeller', 'Mogyoró'].includes(allergen.name)) {
                    textColor = 'text-lime-400';
                    hoverColor = 'group-hover:text-lime-500';
                } 
                else if (allergen.name === 'Tojás') {
                    textColor = 'text-slate-300';
                    hoverColor = 'group-hover:text-slate-400';
                } 
                else {
                    textColor = 'text-red-400';
                    hoverColor = 'group-hover:text-red-500';
                }

                htmlContent += `
                    <div class="border border-gray-700 rounded-xl p-6 flex flex-col transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-[0_0_15px_rgba(52,211,153,0.15)] group">
                    
                    ${isAdmin ? `
                            <div class="text-right">
                                <form action="/api/allergens/${allergen.id}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xl p-2 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white border border-red-500/50 rounded-lg transition-all transform active:scale-95 shadow-sm">🗑️</button>
                                </form>
                            </div>
                        ` : ''}
                    <h3 class="text-2xl font-bold ${textColor} mb-4 ${hoverColor} transition-colors">
                        ${allergen.name}
                    </h3>
            
                    <div class="mt-auto pt-4 border-t border-gray-700/50">
                        <h3 class="font-bold mb-4 transition-colors">
                        ${allergen.desc}
                        </h3>
                    </div>

                    <div class="mt-auto pt-4 border-t border-gray-700/50">
                        <h3 class="text-xl font-bold mb-4 transition-colors">
                        ${allergen.replist}
                        </h3>
                    </div>
                    </div>
                `;
            });

        container.innerHTML = htmlContent;
    })
    .catch(error => console.error('Hiba történt:', error));
}