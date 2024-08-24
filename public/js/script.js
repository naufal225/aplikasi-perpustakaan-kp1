const deleteConfirm = document.querySelector('.confirm-delete-card');
const deleteConfirmText = document.querySelector('.confirm-delete-card-text');
document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector('input[type="number"]');
    const inputJudulBuku = document.getElementById('inputJudul');
    const inputSlug = document.querySelector('input[name="slug"]');
    const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
    let formToSubmit = null;

input.addEventListener('keypress', function(e){
    if(e.key === 'e' || e.key === "E") {
        e.preventDefault();
    }
})

document.getElementById('isbn').addEventListener('keydown', function (e) {
    // Izinkan hanya angka, tanda strip, backspace, dan delete
    if (
        !(
            (e.key >= '0' && e.key <= '9') || 
            e.key === '-' ||
            e.key === 'Backspace' ||
            e.key === 'Delete'
        )
    ) {
        e.preventDefault();
    }
});

document.getElementById('harga').addEventListener('keydown', function(e) {
    if (
        !(
            (e.key >= '0' && e.key <= '9') ||
            e.key == '.' || e.key == ',' ||
            e.key == 'Backspace' ||
            e.key == 'Delete'
        )
    ) {
        e.preventDefault();
    }
})

inputJudulBuku.addEventListener('change', function() {
    fetch('/api/bukuslug?judul=' + inputJudulBuku.value, {
        headers: {
            "X-CSRF-TOKEN" : csrfToken
        }
    })
    .then(response => response.json()) // Convert response to JSON
    .then(data => {
        inputSlug.value = data.slug; // Access the slug property
    })
    .catch(error => console.error('Error:', error)); // Handle any errors
});

})

function deleteConfirmation(e) {
    e.preventDefault();
    formToSubmit = e.target;
    deleteConfirmText.textContent += ` "${e.target.querySelector('button[type="submit"]').dataset.confirm}"`
    deleteConfirm.style.display = "block";
}

function confirmDelete() {
    window.formToSubmit.submit();
    deleteConfirm.style.display = "none";
}

function cancelDelete() {
    deleteConfirm.style.display = "none";
}

