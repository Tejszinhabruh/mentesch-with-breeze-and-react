window.allergenManager = function() {
    return {
        isEditing: false,
        message: '',
        
        allAllergens: [],
        originalIds: [],
        selectedIds: [],

        initData() {
            fetch('/my-allergens-list', {
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
                console.log('API-ból érkező adat:', data);
                this.allAllergens = data.all_allergens || [];
                this.originalIds = data.user_has || [];
                this.selectedIds = [...this.originalIds];
            })
            .catch(error => console.error('Hiba az adatok betöltésekor:', error));
        },

        startEditing() {
            this.selectedIds = [...this.originalIds];
            if (this.selectedIds.length === 0) {
                this.selectedIds.push(null);
            }
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

        getDisplayNames() {
            return this.originalIds.map(id => {
                let found = this.allAllergens.find(a => a.id == id);
                return found ? found.name : '';
            }).filter(name => name !== '');
        },

        saveChanges() {
            let idsToSave = [...new Set(this.selectedIds.filter(id => id !== null && id !== ''))];

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('/my-allergens-update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
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