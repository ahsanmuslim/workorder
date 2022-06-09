$(document).ready(function () {

    const localhost = 'http://localhost/myportpolio/workorder/public/';
    // const localhost = 'http://workorder.argapura.local/public/';
    // const localhost = 'http://localhost/workorder/public/';

    const statuswo = $('.statuswo').val();
    const totalpembelian = $('#totalpembelian').val();
    // console.log(totalpembelian);

    if(totalpembelian == 0){
        $(':input[type="submit"]').prop('disabled', true);
    }

    if(statuswo == 'Closed'){
        $(':input[type="submit"]').prop('disabled', true);
    }
    

    //membuat popover untuk info 
    $('[data-toggle="popover"]').popover({
        trigger: 'focus'
    });

    //script untuk efek zoom pada gambar 
    $('.zoom').hover(function() {
        $(this).addClass('transisi');
    }, function() {
        $(this).removeClass('transisi');
    });

    //script untuk modul pembelian 
    // inisiasi pilihan pada pembelian material
    $("#beli-material").select2();

    var i = $('#jmldata').val();
    $('#add-material').click(function () {


        const id_material = $('#beli-material').val();
        console.log(id_material);

        $.ajax({

            url: localhost + 'material/getMaterial',
            data: {
                id_material: id_material
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(JSON.stringify(data));
                // console.log(id);
                let qty = $('#jumlah-beli').val();
                let total = $('#harga-total').val();
                console.log(qty);
                console.log(total);
                let harga = total / qty;
                let nama = data.nama_material;
                let satuan = data.satuan;

                i++;
                $('#tbl-pembelian').append('<tr id="row' + i + '"><td><input size="10" style="border:0;outline:0" name="id_material[]" value="' + id_material + '" readonly></td><td>' + nama + '</td><td><input size="10" style="border:0;outline:0" name="qty[]" value="' + qty + '" readonly></td><td>' + satuan + '</td><td><input size="10" style="border:0;outline:0" name="harga[]" value="' + harga + '" readonly></td><td><input size="10" style="border:0;outline:0" name="total-beli[]" class="subtotal-beli" value="' + total + '" readonly></td><td><button type="button" name="hapus" id="' + i + '" class="btn btn-danger btn-sm btn_remove"><i class="fas fa-fw fa-trash"></i></button></td></tr>');

                //update grand total beli
                var tbeli = 0;
                $('.subtotal-beli').each(function () {
                    tbeli += +$(this).val();
                });
                console.log(tbeli);
                $('.grandtotal').html(tbeli);
                $('.grandtotal').val(tbeli);
                $('#harga-total').val(0);
                $('#jumlah-beli').val(1);

                if(tbeli == 0){
                    $(':input[type="submit"]').prop('disabled', true);
                } else {
                    $(':input[type="submit"]').prop('disabled', false);
                }

            }

        });


    });

    //menghapus item beli
    $(document).on('click', '.btn_remove', function () {
        var baris = $(this).attr("id");
        $('#row' + baris + '').remove();

        //update grand total beli
        var tbeli = 0;
        $('.subtotal-beli').each(function () {
            tbeli += +$(this).val();
        });
        console.log(tbeli);
        $('.grandtotal').html(tbeli);
        $('.grandtotal').val(tbeli);

        if(tbeli == 0){
            $(':input[type="submit"]').prop('disabled', true);
        } else {
            $(':input[type="submit"]').prop('disabled', false);
        }

    });



    //script untuk menambah work order - hapus baris 
    $('.hapus-baris').on('click', function () {
        var button_id = $(this).attr("id");
        $('#row' + button_id + '').remove();

        //update subtotal
        var sum = 0;
        $('.total-biaya').each(function () {
            sum += +$(this).val();
        });
        console.log(sum);
        $('.grandtotal').html(sum);
        $('#biaya').val(sum);
    });


    //live search material
    $('.field-material').select2();
    //fungsi untuk merubah harga & satuan & total harga pada saat fiel material berubah
    $('.field-material').on('change', function () {

        const id_material = $(this).val();
        console.log(id_material);
        const id = $(this).attr("id");


        $.ajax({

            url: localhost + 'material/getMaterial',
            data: {
                id_material: id_material
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(JSON.stringify(data));
                // console.log(id);
                const qty = $('.qty' + id + '').val();
                const total = qty * data.harga;
                //berfungsi untuk menampilkan data json
                $('.harga' + id + '').val(data.harga);
                $('.satuan' + id + '').val(data.satuan);
                $('#total' + id + '').val(total);

                //update subtotal
                var sum = 0;
                $('.total-biaya').each(function () {
                    sum += +$(this).val();
                });
                console.log(sum);
                $('.grandtotal').html(sum);
                $('#biaya').val(sum);


            }

        });
    });


    //update data total jika qty dirubah
    $("input[name*='qty']").on('change', function () {

        const qty = $(this).val();
        // console.log(qty);
        const id = $(this).attr("id");
        const harga = $('.harga' + id + '').val();
        const total = qty * harga;
        // console.log(total);
        $('#total' + id + '').val(total);

        //update subtotal
        var sum = 0;
        $('.total-biaya').each(function () {
            sum += +$(this).val();
        });
        console.log(sum);
        $('.grandtotal').html(sum);
        $('#biaya').val(sum);
    });


    //fungsi untuk validasi apakah semua aktivity sudah completed
    $('.list-wo-finished').on('change', function () {

        const id_wo = $(this).val();
        console.log(id_wo);

        $.ajax({

            url: localhost + 'activity/getCompleted',
            data: {
                id_wo: id_wo
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data);
                //menampilkan sweet alert jika ada aktifitas yang belum completed 
                if ( data > 0 ){
                    $(':input[type="submit"]').prop('disabled', true);
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Work Order ini ada activity yang belum Completed !!',
                    })
                } else {
                    $(':input[type="submit"]').prop('disabled', false);
                }

            }

        });
    });

    //fungsi untuk validasi apakah semua teknisi ada >= 2 project active 
    $('.teknisi-project-handled').on('change', function () {

        const id_teknisi = $(this).val();
        console.log(id_teknisi);

        $.ajax({

            url: localhost + 'teknisi/getActiveproject',
            data: {
                id_teknisi: id_teknisi
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(JSON.stringify(data));
                //menampilkan sweet alert jika ada aktifitas yang belum completed 
                if ( data > 0 ){
                    Swal.fire(
                    'Task overload ?',
                    'Teknisi sudah handle '+data+ ' work order Active',
                    'question'
                    )
                }

            }

        });
    });

    //fungsi untuk validasi pembelian work dengan plan biaya 0
    $('.wo-tanpa-biaya').on('change', function () {

        const id_wo = $(this).val();
        console.log(id_wo);

        $.ajax({

            url: localhost + 'pembelian/getPlanpembelian',
            data: {
                id_wo: id_wo
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(JSON.stringify(data));
                //menampilkan sweet alert jika ada aktifitas yang belum completed 
                if ( data.plan_biaya == 0 ){
                    Swal.fire(
                    'Mau beli material ?',
                    'Work order ini menggunakan material bekas, plan biaya 0',
                    'question'
                    )
                }
            }
        });

        //cek apakah uang sudah diambil atau belum
        $.ajax({

            url: localhost + 'pembelian/getCash',
            data: {
                id_wo: id_wo
            },
            method: 'post',
            dataType: 'json',
            success: function (data2) {
                console.log(JSON.stringify(data2));
                //menampilkan sweet alert jika uang belum diambil
                if ( data2 ){
                    Swal.fire(
                    'Mau beli material ?',
                    'Dana cash belum diambil di Finance !',
                    'question'
                    )
                }
            }
        });



    });





    //fungsi untuk menampilka nama file ynag di upload
    $('.custom-file-input').on('change', function () {

        var size =(this.files[0].size);

        if(size > 2000000) {
            //disabled tomol submit
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            $(':input[type="submit"]').prop('disabled', true);
            //menampilkan sweet alert jika file terlalu besar
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'File yang Anda upload lebih dari 2Mb !!',
            })
        } else {
            //merubah value filed dengan nama file
            $(':input[type="submit"]').prop('disabled', false);
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }


    });

    //fungsi untuk mencegah approve double
    let countApp = 0;
    $('#tombol-approve').on('click', function(evt){
      if (countApp == 0) {
        countApp++;
      } else {
        evt.preventDefault();
      }
    });


    //fungsi konfirmasi hapus 
    $('.tombol-hapus').on('click', function (e) {

        e.preventDefault();
        const href = $(this).attr('href');

        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: "Data yang Anda hapus tidak dapat di Recovery !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Saya yakin !'
        }).then((result) => {
            if(result.value){
                document.location.href = href;
            }       
        })

    });


    //fungsi modal shoe detail activity di antrian
    $('.modalShowActivity').on('click', function () {

        //hapus baris dari model sebelumnya
        $('#tblmodalactivity tr:not(:first)').remove();
        const id_wo = $(this).data('id_wo');

        $.ajax({

            url: localhost + 'antrian/getActivity',
            data: {
                id_wo: id_wo
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(data[0].tgl_activity);
                //berfungsi untuk menampilkan data activity ke form modal
                for ( let i = 0 ; i < data.length ; i++ ){
                    $('#tblmodalactivity').append('<tr><td style="text-align:center">'+(i+1)+'</td><td>' + data[i].tgl_activity + '</td><td>' + data[i].nama_activity + '</td><td>' + data[i].status + '</td></tr>');
                }
            
            }

        });

    });

    //fungsi modal shoe detail problem di antrian
    $('.modalShowProblem').on('click', function () {

        //hapus baris dari model sebelumnya
        $('#tblmodalproblem tr:not(:first)').remove();
        const id_wo = $(this).data('id_wo');
        console.log(id_wo);

        $.ajax({

            url: localhost + 'workorder/getProblem',
            data: {
                id_wo: id_wo
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log(JSON.stringify(data));
                //berfungsi untuk menampilkan data problem ke form modal
                for ( let i = 0 ; i < data.length ; i++ ){
                    $('#tblmodalproblem').append('<tr><td style="text-align:center">'+(i+1)+'</td><td>' + data[i].id_wo + '</td><td>' + data[i].problem + '</td><td>' + data[i].tindak_lanjut + '</td><td>' + data[i].pic + '</td><td>' + data[i].status + '</td></tr>');
                }
            
            }

        });

    });

    //FUNGSI UNTUK MENAMBAHKAN ID_WO KE FORM MODAL
    $('.modalAddEstimasi').on('click', function(){
        const id_wo = $(this).data('id_wo');
        console.log(id_wo);
        $('#id_wo_estimasi').val(id_wo);
    });


    //fungsi modal edit role access
    $('.modalEditRole').on('click', function () {


        $('.tombolTambahRole').on('click', function () {


            $('#judulModal').html('Tambah Role');
            $('.modal-footer button[type=submit]').html('Tambah Data');
            //baris ini berfungsi untuk menghilangkan data yang ada di modal karena fungsi ajax getUbah masih tersimpan
            $('#role').val('');

        });

        // console.log('Edit');
        $('#judulModal').html('Update Role');
        $('.modal-footer button[type=submit]').html('Update Data');
        $('.modal-body form').attr('action', localhost + 'role/update');

        const id_role = $(this).data('id_role');
        // console.log(nim);

        $.ajax({

            url: localhost + 'role/getEdit',
            data: {
                id_role: id_role
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                console.log('data');

                //berfungsi untuk menampilkan data json ke dalam modal tampil ubah
                $('#id_role').val(data.id_role);
                $('#role').val(data.role);
            }

        });

    });

    //fungsi modal edit menu
    $('.modalEditMenu').on('click', function () {


        $('.tombolTambahMenu').on('click', function () {


            $('#judulModal').html('Tambah Menu');
            $('.modal-footer button[type=submit]').html('Tambah Data');
            //baris ini berfungsi untuk menghilangkan data yang ada di modal karena fungsi ajax getUbah masih tersimpan
            $('#menu').val('');

        });

        // console.log('Edit');
        $('#judulModal').html('Update Menu');
        $('.modal-footer button[type=submit]').html('Update Data');
        $('.modal-body form').attr('action', localhost + 'menu/updateMenu');

        const id_menu = $(this).data('id_menu');
        // console.log(nim);

        $.ajax({

            url: localhost + 'menu/getEdit',
            data: {
                id_menu: id_menu
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                // console.log('data');

                //berfungsi untuk menampilkan data json ke dalam modal tampil ubah
                $('#id_menu').val(data.id_menu);
                $('#menu').val(data.nama_menu);
            }

        });

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblworkorder').DataTable({

        
        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [10]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],


        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Work Order',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblmaterial').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [8]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Raw Material',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblactivity').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [6]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Detail Activity',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblproblem').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [6]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Problem Work Order',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblserahterima').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [7]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Serah Terima Work Order',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblkaskeluar').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [7]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Kas Keluar',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblpembelian').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [6]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Pembelian Material',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblsupplier').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [6]
        }],
        "order": [0, "asc"],

        "lengthMenu": [20, 40, 60],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Supplier',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tbluser').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [8]
        }],
        "order": [0, "asc"],

        "lengthMenu": [20, 40, 60],

        dom: 'Bfrtip',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data User',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });

    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblrole').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [3]
        }],
        "order": [0, "asc"],

        "lengthMenu": [50, 75, 100],

        dom: 'Bfrti',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Data Role Access',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });
    
    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblnotifikasi').DataTable({


        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [3]
        }],
        "order": [0, "asc"],

        "lengthMenu": [20, 40, 60],

        dom: 'Bfrti',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Notification Message',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });
        
    //fungsi untuk memanggil datatable Library dengan metode Client Side PRocessing
    $('#tblteknisi').DataTable({

        columnDefs: [{
            "searchable": false,
            "orderable": false,
            "targets": [7]
        }],
        "order": [0, "asc"],

        "lengthMenu": [20, 40, 60],

        dom: 'Bfrti',
        buttons: [{
                extend: 'pdf',
                orientation: 'landscape',
                pageSize: 'A4',
                title: 'Teknisi',
                download: 'open'
            },
            'csv', 'excel', 'print', 'copy'
        ]

    });
    









});