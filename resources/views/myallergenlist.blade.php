<x-layout>
    <x-slot:title>Allergénlistám</x-slot:title>
    <x-slot:heading>Allergénlistám</x-slot:heading>
    <x-slot>
                <div class="max-w-4xl mx-auto p-6 bg-white/5 rounded-lg shadow-lg backdrop-blur-sm border border-white/10 mt-8" 
             x-data="allergenManager()" 
             x-init="initData()">

            <div x-show="!isEditing" x-transition>
                <div class="text-center md:text-left">
                    <h2 class="text-2xl font-semibold text-white mb-4">Allergénlistád</h2>

                    <div class="bg-white/10 p-4 rounded-md text-gray-200 mb-6 flex flex-wrap gap-2 min-h-[60px] items-center">
                        <template x-if="originalIds.length > 0">
                            <template x-for="name in getDisplayNames()" :key="name">
                                <span class="px-3 py-1 bg-red-500/20 border border-red-500/30 text-red-200 rounded-full text-sm" x-text="name"></span>
                            </template>
                        </template>
                        <template x-if="originalIds.length === 0">
                            <span class="text-gray-400 text-sm">Sajnos még nincs listád:(</span>
                        </template>
                    </div>

                    <button @click="startEditing()" class="inline-block px-6 py-2 bg-[#49ab6d] hover:bg-[#3d915c] text-white font-medium rounded-md transition duration-200 shadow-md">
                        <span x-text="originalIds.length > 0 ? 'Lista módosítása' : 'Lista létrehozása'"></span>
                    </button>
                </div>
            </div>

            <div x-show="isEditing" x-transition style="display: none;" class="bg-white/10 p-6 rounded-md">
                <h2 class="text-xl font-semibold text-white mb-4">Lista szerkesztése</h2>

                <div class="space-y-3 mb-6">
                    <template x-for="(selectedId, index) in selectedIds" :key="index">
                        <div class="flex items-center gap-3">

                            <select x-model.number="selectedIds[index]" class="flex-grow bg-[#1b1b18] border border-gray-600 text-gray-200 text-sm rounded-md focus:ring-[#49ab6d] focus:border-[#49ab6d] block w-full p-2.5">
                                <option value="">Válassz allergént!</option>
                                <template x-for="allergen in allAllergens" :key="allergen.id">
                                    <option :value="allergen.id" x-text="allergen.name"></option>
                                </template>
                            </select>

                            <button @click="removeRow(index)" type="button" class="p-2.5 bg-red-500/20 hover:bg-red-500/40 text-red-400 rounded-md transition" title="Törlés">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                        </div>
                    </template>
                </div>

                <div class="flex flex-wrap gap-3 mt-4">
                    <button @click="addRow()" type="button" class="px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white font-medium rounded-md transition text-sm">
                        + Új allergén
                    </button>

                    <button @click="saveChanges()" type="button" class="px-6 py-2 bg-[#49ab6d] hover:bg-[#3d915c] text-white font-medium rounded-md transition shadow-md">
                        Mentés
                    </button>

                    <button @click="cancelEditing()" type="button" class="px-4 py-2 bg-transparent border border-gray-500 text-gray-300 hover:bg-gray-700 rounded-md transition text-sm">
                        Mégse
                    </button>
                </div>

                <p x-show="message" x-text="message" class="mt-4 text-[#49ab6d] font-medium" x-transition></p>
            </div>
        </div>

        <script>
function allergenManager() {
    return {
        isEditing: false,
        message: '',
        
        allAllergens: [],
        originalIds: [],
        selectedIds: [],

        initData() {
            fetch('/api/my-allergens-list', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }) 
            .then(response => {
                if (!response.ok) throw new Error('Hiba a lekérdezésnél: ' + response.status);
                return response.json();
            })
            .then(data => {
                this.allAllergens = data.all_allergens || [];
                this.originalIds = data.user_has || [];
                this.selectedIds = [...this.originalIds];
            })
            .catch(error => console.error('Hiba az adatok betöltésekor:', error));
        },

        startEditing() {
            this.selectedIds = [...this.originalIds];
            if (this.selectedIds.length === 0) {
                this.selectedIds.push('');
            }
            this.isEditing = true;
            this.message = '';
        },

        cancelEditing() {
            this.isEditing = false;
        },

        addRow() {
            this.selectedIds.push('');
        },

        removeRow(index) {
            this.selectedIds.splice(index, 1);
        },

        getDisplayNames() {
            return this.originalIds.map(id => {
                let found = this.allAllergens.find(a => a.id == id);
                return found ? found.name : '';
            }).filter(name => name !== '');
        },

        saveChanges() {
            let idsToSave = [...new Set(this.selectedIds.filter(id => id !== ''))];

            fetch('/api/my-allergens-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ allergen_ids: idsToSave })
            })
            .then(response => {
                if (!response.ok) throw new Error('Hiba a mentésnél');
                return response.json();
            })
            .then(data => {
                this.originalIds = [...idsToSave];
                this.message = data.message || 'Sikeresen mentve!';
                
                setTimeout(() => {
                    this.isEditing = false;
                    this.message = '';
                }, 1500);
            })
            .catch(error => {
                console.error('Hiba:', error);
                this.message = 'Hiba történt a mentés során.';
            });
        }
    }
}
</script>
    </x-slot>
</x-layout>