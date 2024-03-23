@extends('layouts.template') @section('template')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Form DNPG Upload</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="#">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Advanced Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    DataTable with default features
                                </h3>
                            </div>

                            <div class="card-body">
                                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="data-table"
                                                class="table table-bordered table-striped dataTable dtr-inline"
                                                aria-describedby="example1_info">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>UUID</th>
                                                        <th>URL</th>
                                                        <th>Keterangan</th>
                                                        <th>Image Name</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>UUID</th>
                                                        <th>URL</th>
                                                        <th>Keterangan</th>
                                                        <th>Image Name</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @endsection @section('js')
    {{-- external script CDN --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment-with-locales.min.js"
        integrity="sha512-4F1cxYdMiAW98oomSLaygEwmCnIP38pb4Kx70yQYqRwLVCs3DbRumfBq82T08g/4LJ/smbFGFpmeFlQgoDccgg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- ViwersJS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"
        integrity="sha512-EC3CQ+2OkM+ZKsM1dbFAB6OGEPKRxi6EDRnZW9ys8LghQRAq6cXPUgXCCujmDrXdodGXX9bqaaCRtwj4h4wgSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk zoom in dan zoom out gambar
            $(".zoomable-image").on("click", function() {
                $(this).toggleClass("zoomed-in");
            });
        });
        $(function() {
            var table = $("#data-table").DataTable({
                scrollY: 500, // Sesuaikan dengan tinggi maksimum yang diinginkan
                scrollX: true,
                scrollCollapse: true,
                paging: true,
                fixedHeader: true,
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dnpg.index') }}",
                    // dataSrc: function (data) {
                    //     console.log(data); // Tampilkan data di konsol browser sebelum dimuat ke dalam DataTable
                    //     return data;
                    // }
                },
                columns: [{
                        data: "id",
                        name: "id",
                    },
                    {
                        data: "dnpg_no",
                        name: "dnpg_no",
                    },
                    {
                        data: "dnpg_no",
                        name: "dnpg_no",
                        // render: function(data, type, row) {
                        //     // Jika tipe render adalah display, tampilkan tautan
                        //     if (type === 'display') {
                        //         return '<a href="' + data + '" target="_blank">Klik di sini</a>';
                        //     }
                        //     // Jika tipe render bukan display, kembalikan data aslinya
                        //     return data;
                        // }
                    },
                    {
                        data: "images", // Kolom yang menyimpan informasi gambar
                        name: "images", // Nama kolom di sumber data
                        render: function(data, type, row) {
                            // Jika tipe render adalah display, tampilkan gambar
                            if (type === "display") {
                                var images = '<ul class="image-list">';
                                data.forEach(function(image) {
                                    images +=
                                        '<li><img src="' +
                                        image.url +
                                        '" alt="' +
                                        image.keterangan +
                                        '" class="img-thumbnail img-zoom"></li>';
                                });
                                images += "</ul>";
                                return images;
                            }
                            // Jika tipe render bukan display, kembalikan data aslinya
                            return data;
                        },
                        className: "image",
                    },
                    {
                        data: "created_at",
                        name: "created_at",
                        render: function(data, type, row) {
                            // Jika tipe render adalah display, tampilkan tanggal dan waktu
                            if (type === "display") {
                                // Ubah format tanggal sesuai kebutuhan Anda, contoh menggunakan moment.js
                                return moment(data).format("YYYY-MM-DD HH:mm:ss");
                            }
                            // Jika tipe render bukan display, kembalikan data aslinya
                            return data;
                        },
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },
                ],
            });
            table.on("click", "td.image img", function(e) {
                e.preventDefault();

                // Membuat array untuk menyimpan semua gambar dalam satu baris tabel
                var images = [];

                // Membuat array untuk menyimpan caption dari setiap gambar
                var captions = [];

                // Mengambil semua gambar dalam satu baris tabel
                $(this)
                    .closest("tr")
                    .find("td.image img")
                    .each(function() {
                        var image = new Image();
                        var caption = $(this).attr("alt"); // Ambil caption dari atribut alt gambar
                        image.src = $(this).attr("src");
                        image.alt = caption;
                        images.push(image);
                        captions.push(caption);
                    });

                // Membuat kontainer baru untuk semua gambar dalam baris tabel
                var container = document.createElement("div");

                // Memasukkan semua gambar ke dalam kontainer
                images.forEach(function(image, index) {
                    var figure = document.createElement("figure");
                    var figcaption = document.createElement("figcaption");
                    figcaption.textContent = captions[
                        index]; // Tambahkan caption ke dalam figcaption
                    figure.appendChild(image);
                    figure.appendChild(figcaption);
                    container.appendChild(figure);
                });

                // Membuat viewer dengan kontainer yang berisi semua gambar dalam baris tabel
                var viewer = new Viewer(container, {
                    zoomRatio: 2,
                    maxZoomRatio: 2,
                    hidden: function() {
                        viewer.destroy();
                    },
                });
                // Menampilkan viewer
                viewer.show();
            });
        });
    </script>
@endsection
