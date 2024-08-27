
const deleteConfirm = document.querySelector('.confirm-delete-card');
const deleteConfirmText = document.querySelector('.confirm-delete-card-text');
const itemForDelete = document.querySelector('.itemForDelete');
const input = document.querySelector('input[type="number"]');
const inputJudulBuku = document.getElementById('inputJudul');
const inputKategori = document.getElementById('kategori');
const inputSlug = document.querySelector('input[name="slug"]');
const csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute("content");
const gambar = document.getElementById('gambar');
const inputKodeMember = document.getElementById("kodeMember");
const btnTambah = document.getElementById('btnTambahTransaksi')

let preview = document.querySelector('img.img-preview');



document.addEventListener("DOMContentLoaded", function() {
    let formToSubmit = null;

if(input) {
    input.addEventListener('keypress', function(e){
        if(e.key === 'e' || e.key === "E") {
            e.preventDefault();
        }
    })
}

if(document.getElementById('isbn')) {
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
}

if(document.getElementById('harga')) {
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
    });
}


if(inputJudulBuku) {
    inputJudulBuku.addEventListener('change', function() {
        fetch('/api/bukuslug?judul=' + inputJudulBuku.value, {
            headers: {
                "X-CSRF-TOKEN" : csrfToken
            }
        })
        .then(response => response.json()) // Convert response to JSON
        .then(data => {
            console.log(data)
            inputSlug.value = data.slug; // Access the slug property
        })
        .catch(error => console.error('Error:', error)); // Handle any errors
    });
}


if(inputKategori) {
    inputKategori.addEventListener('change', function() {
        fetch('/api/kategorislug?kategori=' + inputKategori.value, {
            headers: {
                "X-CSRF-TOKEN" : csrfToken
            }
        }) 
        .then(response => response.json())
        .then(data => {
            inputSlug.value = data.slug;
        })
        .catch(error => console.error('Error:', error)); 
    });

}

if(inputKodeMember && btnTambah) {
    btnTambah.addEventListener('click', function() {
        if(!inputKodeMember.hasAttribute("readonly")) {
            inputKodeMember.setAttribute("readonly", true);
        }
    })
}

})

function deleteConfirmation(e) {
    e.preventDefault();
    formToSubmit = e.target;
    itemForDelete.textContent = ` "${e.target.querySelector('button[type="submit"]').dataset.confirm}"`
    deleteConfirm.style.display = "block";
}

function confirmDelete() {
    window.formToSubmit.submit();
    deleteConfirm.style.display = "none";
}

function cancelDelete() {
    deleteConfirm.style.display = "none";
}

function previewGambar() {
    preview.style.display = "block";
    const fileReader = new FileReader();
    fileReader.readAsDataURL(gambar.files[0]);
    fileReader.onload = function(e) {
        preview.src = e.target.result;
    }
}

btnTambah.addEventListener('click', function() {
    if(!inputKodeMember.hasAttribute("readonly")) {
        inputKodeMember.setAttribute("readonly", true);
    }
})