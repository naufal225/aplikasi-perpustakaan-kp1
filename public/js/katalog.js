$(document).ready(function() {
    const API = "/api/katalog/searchDataBuku";

    const fetchAllData = () => {
        $.ajax({
            url: API,
            type: "GET",
            success: function(response) {
                $("#search-result").empty();
                response[0]['data'].forEach(item => {
                    let card;

                    if(item.stok == 0) {
                        card = `
                        <div class="col-sm-3">
                            <a href="/katalog/detail?judul=${item.judul_buku}" class="text-decoration-none text-dark">
                                <div class="card mb-4 shadow">
                                    <img src="/storage/${item.gambar}" class="card-img-top border-bottom" alt="${item.judul_buku}">
                                    <div class="card-body">
                                        <p>${item.penulis}</p>
                                        <h6 class="card-title mt-1 mb-2 fs-5">${item.judul_buku}</h6>
                                        <div class="row">
                            <div class="col-sm-12">
                                <p>Stok: 
                                        <span class="bg-danger text-light px-1 py-2">${item.stok}</span>
                                </p>
                            </div>
                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `
                    } else {
                        card = `
                        <div class="col-sm-3">
                            <a href="/katalog/detail?judul=${item.judul_buku}" class="text-decoration-none text-dark">
                                <div class="card mb-4 shadow">
                                    <img src="/storage/${item.gambar}" class="card-img-top border-bottom" alt="${item.judul_buku}">
                                    <div class="card-body">
                                        <p>${item.penulis}</p>
                                        <h6 class="card-title mt-1 mb-2 fs-5">${item.judul_buku}</h6>
                                        <div class="row">
                            <div class="col-sm-12">
                                <p>Stok: 
                                        <span class="bg-success text-light px-1 py-2">${item.stok}</span>
                                </p>
                            </div>
                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `
                    }

                    $("#search-result").append(card);
                });
            },
            error: function(err) {
                console.log("Tidak dapat memuat data");
            }
        });
    } 

    $("#search-input").on("keyup", function() {
        let query = $(this).val();

        if(query.length > 2) {
            $.ajax({
                url: API,
                type: "GET",
                data: {judul_buku: query},
                success: function(response) {
                    $("#search-result").empty();
                    response[0]['data'].forEach(item => {
                        let card;

                    if(item.stok == 0) {
                        card = `
                        <div class="col-sm-3">
                            <a href="/katalog/detail?judul=${item.judul_buku}" class="text-decoration-none text-dark">
                                <div class="card mb-4 shadow">
                                    <img src="/storage/${item.gambar}" class="card-img-top border-bottom" alt="${item.judul_buku}">
                                    <div class="card-body">
                                        <p>${item.penulis}</p>
                                        <h6 class="card-title mt-1 mb-2 fs-5">${item.judul_buku}</h6>
                                        <div class="row">
                            <div class="col-sm-12">
                                <p>Stok: 
                                        <span class="bg-danger text-light px-1 py-2">${item.stok}</span>
                                </p>
                            </div>
                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `
                    } else {
                        card = `
                        <div class="col-sm-3">
                            <a href="/katalog/detail?judul=${item.judul_buku}" class="text-decoration-none text-dark">
                                <div class="card mb-4 shadow">
                                    <img src="/storage/${item.gambar}" class="card-img-top border-bottom" alt="${item.judul_buku}">
                                    <div class="card-body">
                                        <p>${item.penulis}</p>
                                        <h6 class="card-title mt-1 mb-2 fs-5">${item.judul_buku}</h6>
                                        <div class="row">
                            <div class="col-sm-12">
                                <p>Stok: 
                                        <span class="bg-success text-light px-1 py-2">${item.stok}</span>
                                </p>
                            </div>
                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `
                    }

                    $("#search-result").append(card);
                    });
                },
                error: function(err) {
                    console.log("Tidak dapat memuat data");
                }
            });
        } else {
            fetchAllData();
        }

    })
});