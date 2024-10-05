$(document).ready(function() {
    let formToSubmit = null;

    // Cek status readonly di localStorage saat halaman di-load
    // if (localStorage.getItem("isReadonly") === "true") {
    //     $('#kodeMember').attr("readonly", true);
    //     $('#kodeMember').val(localStorage.getItem("kodeMember") || "");
    // }

    // $("#btnTambahTransaksi").on('click', function(event) {
    //     if (!$("#kodeMember").attr("readonly")) {
    //         event.preventDefault();
    //         localStorage.setItem("kodeMember", $(this).val());
    //         $("#kodeMember").attr("readonly", true);
    //         localStorage.setItem("isReadonly", "true");
    //     }
    // });

    $('input[type="number"]').on('keypress', function(e){
        if(e.key === 'e' || e.key === "E") {
            e.preventDefault();
        }
    });

    $('#isbn').on('keydown', function (e) {
        if (!(
            (e.key >= '0' && e.key <= '9') || 
            e.key === '-' ||
            e.key === 'Backspace' ||
            e.key === 'Delete'
        )) {
            e.preventDefault();
        }
    });

    $('#harga').on('keydown', function(e) {
        if (!(
            (e.key >= '0' && e.key <= '9') || 
            e.key == '.' || e.key == ',' || 
            e.key == 'Backspace' || 
            e.key == 'Delete'
        )) {
            e.preventDefault();
        }
    });

    $('#inputJudul').on('change', function() {
        $.ajax({
            url: '/api/bukuslug',
            type: 'GET',
            data: { judul: $(this).val() },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                $('input[name="slug"]').val(data.slug);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

    $('#kategori').on('change', function() {
        $.ajax({
            url: '/api/kategorislug',
            type: 'GET',
            data: { kategori: $(this).val() },
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
            success: function(data) {
                $('input[name="slug"]').val(data.slug);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

    $('#btnTambahTransaksi').on('click', function() {
        if(!$('#kodeMember').attr("readonly")) {
            $('#kodeMember').attr("readonly", true);
        }
    });

    $(".btn-kembali").each(function() {
        $(this).on('click', function() {
            let kodeBuku = $(this).data('buku');
            let kodePeminjaman = $('meta[name="kode_peminjaman"]').attr('content');
            let kodeMember = $('meta[name="kode_member"]').attr('content');

            $.ajax({
                url: '/api/transaksi/kembali-buku',
                type: 'POST',
                contentType: 'application/json',
                headers: { 
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: JSON.stringify({
                    kode_peminjaman: kodePeminjaman,
                    kode_member: kodeMember,
                    kode_buku: kodeBuku
                }),
                success: function(data) {
                    if(data.success) {
                        $('#row-' + kodeBuku).remove();
                    } else {
                        alert('Gagal mengembalikan buku.');
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });
    });
});

function deleteConfirmation(e) {
    e.preventDefault();
    formToSubmit = e.target;
    $('.itemForDelete').text(` "${$(e.target).find('button[type="submit"]').data('confirm')}"`);
    $('.confirm-delete-card').show();
}

function confirmDelete() {
    formToSubmit.submit();
    $('.confirm-delete-card').hide();
}

function cancelDelete() {
    $('.confirm-delete-card').hide();
}

function previewGambar() {
    $('.img-preview').show();
    let fileReader = new FileReader();
    fileReader.readAsDataURL($('#gambar')[0].files[0]);
    fileReader.onload = function(e) {
        $('.img-preview').attr('src', e.target.result);
    }
}

// $('.akun').on('mouseleave', function() {
//     $('#profile-card').fadeOut(1000); // Smooth fade-out effect
// });

// $('.akun').on('mouseenter', function() {
//     $('#profile-card').fadeIn(1000); // Smooth fade-in effect
// });
