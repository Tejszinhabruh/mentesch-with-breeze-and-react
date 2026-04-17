let currentDeleteFormId = null;

window.openDeleteModal = function(reviewId) {
    currentDeleteFormId = `delete-form-${reviewId}`;
    const modal = document.getElementById('delete-modal');
    modal.classList.remove('hidden');
    modal.querySelector('div').classList.add('scale-100', 'opacity-100');
}

window.closeDeleteModal = function() {
    const modal = document.getElementById('delete-modal');
    modal.classList.add('hidden');
}

document.getElementById('confirm-delete-btn').addEventListener('click', function() {
    if (currentDeleteFormId) {
        document.getElementById(currentDeleteFormId).submit();
    }
});

window.onclick = function(event) {
    const modal = document.getElementById('delete-modal');
    if (event.target == modal) {
        closeDeleteModal();
    }
}