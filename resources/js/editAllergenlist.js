const AllergenApi = {
    getHeaders() {
        return {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        };
    },

    async fetchMyAllergens() {
        const response = await fetch('/my-allergens-list', { headers: this.getHeaders() });
        if (!response.ok) throw new Error('Nem sikerült az adatok lekérése.');
        return await response.json();
    },

    async updateMyAllergens(ids) {
        const response = await fetch('/my-allergens-update', {
            method: 'POST',
            headers: this.getHeaders(),
            body: JSON.stringify({ allergen_ids: ids })
        });
        if (!response.ok) throw new Error('Hiba történt a mentés során.');
        return await response.json();
    }
};

window.allergenManager = function() {
    return {
        isEditing: false,
        message: '',
        allAllergens: [],
        originalIds: [],
        selectedIds: [],

        async init() {
            try {
                const data = await AllergenApi.fetchMyAllergens();
                this.allAllergens = data.all_allergens || [];
                this.originalIds = data.user_has || [];
                this.selectedIds = [...this.originalIds];
            } catch (error) {
                console.error(error.message);
            }
        },

        startEditing() {
            this.selectedIds = this.originalIds.length > 0 ? [...this.originalIds] : [null];
            this.isEditing = true;
            this.message = '';
        },

        cancelEditing() {
            this.isEditing = false;
        },

        addRow() {
            this.selectedIds.push(null);
        },

        removeRow(index) {
            this.selectedIds.splice(index, 1);
        },

        get displayNames() {
            return this.originalIds
                .map(id => this.allAllergens.find(a => a.id == id)?.name)
                .filter(Boolean);
        },

        async saveChanges() {
            const idsToSave = [...new Set(this.selectedIds.filter(id => id))];

            try {
                const data = await AllergenApi.updateMyAllergens(idsToSave);
                
                this.originalIds = [...idsToSave];
                this.message = data.message || 'Sikeresen mentve!';
                
                setTimeout(() => {
                    this.isEditing = false;
                    this.message = '';
                }, 1500);
            } catch (error) {
                this.message = error.message;
            }
        }
    };
};