@extends('layouts.template')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/dropzone/min/dropzone.min.css') }}">
@endsection
@section('template')
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
                        <div class="card card-default">
                            <div class="card-body">
                                <div id="actions" class="row">
                                    <div class="col-lg-6">
                                        <div class="btn-group w-100">
                                            <span class="btn btn-success col fileinput-button">
                                                <i class="fas fa-plus"></i>
                                                <span>Add files</span>
                                            </span>
                                            <button type="submit" class="btn btn-primary col start">
                                                <i class="fas fa-upload"></i>
                                                <span>Start upload</span>
                                            </button>
                                            <button type="reset" class="btn btn-danger col deleteAll">
                                                <i class="fas fa-times-circle"></i>
                                                <span>Delete All</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 d-flex align-items-center">
                                        <div id="loading-overlay"
                                            class="spinner-border text-secondary justify-content-center align-items-center"
                                            role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="fileupload-process w-100">
                                            <div id="total-progress" class="progress progress-striped active"
                                                role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                <div class="progress-bar progress-bar-success" style="width:0%;"
                                                    data-dz-uploadprogress></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="dnpgno">NO DNPG</label>
                                            <input type="text" class="form-control dnpgno" id="dnpgno"
                                                placeholder="NO DNPG" data-dz-dnpgno>

                                        </div>
                                    </div>
                                </div>
                                <div class="table table-striped files" id="previews">
                                    <div id="template">
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="col-auto">
                                                    <span class="preview">
                                                        <img src="data:," alt data-dz-thumbnail />
                                                    </span>
                                                </div>
                                                <div class="col d-flex align-items-center">
                                                    <p class="mb-0">
                                                        <span class="lead" data-dz-name></span> ( <span
                                                            data-dz-size></span>)
                                                    </p>
                                                    <strong class="error text-danger" data-dz-errormessage></strong>
                                                </div>
                                                <div class="col-4 d-flex align-items-center">
                                                    <div class="progress progress-striped active w-100" role="progressbar"
                                                        aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                                                        <div class="progress-bar progress-bar-success" style="width:0%;"
                                                            data-dz-uploadprogress></div>
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex align-items-center">
                                                    <div class="btn-group">
                                                        <button class="btn btn-primary start">
                                                            <i class="fas fa-upload"></i>
                                                            <span>Start</span>
                                                        </button>
                                                        <button data-dz-remove class="btn btn-warning cancel">
                                                            <i class="fas fa-times-circle"></i>
                                                            <span>Cancel</span>
                                                        </button>
                                                        <button data-dz-remove class="btn btn-danger delete">
                                                            <i class="fas fa-trash"></i>
                                                            <span>Delete</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="keterangan">Keterangan</label>
                                                    <input type="text" class="form-control keterangan" id="keterangan"
                                                        placeholder="keterangan" data-dz-keterangan>
                                                </div>
                                            </div>
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
@endsection
@section('js')
    <script src="{{ asset('assets/plugins/dropzone/min/dropzone.min.js') }}"></script>
    <script>
        window.onload = function() {
            document.getElementById("loading-overlay").classList.add("d-none");
        };

        Dropzone.autoDiscover = false
        document.querySelector("#actions .deleteAll").style.display = 'none';
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, {
            url: "{{ route('dnpg.store') }}",
            headers: {
                'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
            },
            uploadMultiple: true,
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false,
            previewsContainer: "#previews",
            clickable: ".fileinput-button",
        })
        myDropzone.on("addedfile", function(file) {
            document.querySelector("#actions .deleteAll").style.display = 'block';

            const keterangan = file.previewElement.querySelector(".keterangan").value;

            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })
        myDropzone.on("sendingmultiple", function(file, xhr, formData) {
            // Menampilkan overlay
            document.getElementById("loading-overlay").classList.remove("d-none");
            // Menonaktifkan semua elemen interaktif
            document.querySelectorAll('button, input, select, textarea').forEach(function(element) {
                element.setAttribute('disabled', 'disabled');
            });
            const dnpgno = document.getElementsByClassName("dnpgno")[0].value;

            formData.append("dnpgno", dnpgno); // Menambahkan DNPGNO ke formData
            // Menyiapkan data file untuk dikirim
            file.forEach(function(file) {
                const keterangan = file.previewElement.querySelector(".keterangan").value;
                formData.append("files[]", file);
                formData.append("keterangan[]", keterangan); // Menambahkan keterangan file
            });

            document.querySelector("#total-progress").style.opacity = "1";
            myDropzone.getFilesWithStatus(Dropzone.ADDED).forEach(function(file) {
                file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
            });

        })
        myDropzone.on("queuecomplete", function(progress) {
            // Menyembunyikan overlay
            document.getElementById("loading-overlay").classList.add("d-none");
            // Mengaktifkan kembali semua elemen interaktif
            document.querySelectorAll('button, input, select, textarea').forEach(function(element) {
                element.removeAttribute('disabled');
            });
            document.querySelector("#total-progress").style.opacity = "0"
        })
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))

            document.querySelectorAll('.cancel, .delete').forEach(function(element) {
                element.style.display = 'none';
            });
        }
        myDropzone.on("successmultiple", function(file, response) {
            // console.log(response);
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                    $('#dnpgno').val('')
                    myDropzone.removeAllFiles(file);
                    document.querySelector("#actions .deleteAll").style.display = 'none';
                }
            });
            Toast.fire({
                icon: "success",
                title: response.message
            });
        });
        myDropzone.on("error", function(file, errorMessage, xhr) {
            console.log(errorMessage);
            var error = errorMessage.message; // Mengambil pesan error dnpgno

            // Menampilkan pesan error ke dalam elemen HTML
            file.previewElement.querySelector('[data-dz-errormessage]').textContent = error;

            // // Jika terjadi kesalahan, aktifkan kembali tombol "Start Upload"
            // myDropzone.getFilesWithStatus(Dropzone.ADDED).forEach(function(file) {
            //     file.previewElement.querySelector(".start").removeAttribute("disabled", "disabled");
            // });
        });
        document.querySelector("#actions .deleteAll").onclick = function() {
            myDropzone.removeAllFiles(true);
        }
    </script>
@endsection
