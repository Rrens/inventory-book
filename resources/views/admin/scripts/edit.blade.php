    <script>
        window.addEventListener('popstate', function(event) {
            event.preventDefault();
            var currentState = history.state;
            // console.log(currentState)

            // Memeriksa apakah perubahan navigasi adalah mundur (dari state sebelumnya)
            if (currentState && currentState.previousState) {
                // Kode yang akan dijalankan saat terjadi perubahan navigasi mundur
                location.reload()
                console.log('Navigasi mundur');
                // Lakukan tindakan yang diinginkan saat terjadi perubahan navigasi mundur
            }
        });

        function modal(btn) {
            // var row = btn.closest('tr');
            // row.remove();
            var row = btn.getAttribute('data-id');
            console.log(row)
            $('#id_penjualan_edit').val(row);

            let data = [];

            $('#table1 tbody tr').each(function() {
                // const data_id = $(this).find('td:eq(6)')[0]['firstElementChild']['attributes'][4]['nodeValue'];
                const data_id = $(this).find('td:eq(6)')[0]['firstElementChild']['attributes'][4]['nodeValue'];
                // console.log(id_barang, kategori, nama_barang, jumlah_barang, harga_jual, harga_akhir)
                data.push({
                    data_id,
                });
            });


            let newRow = '';

            // $('#table_kasir_edit tbody').append(newRow);

            $.ajax({
                url: `penjualan/get-id-penjualan/${row}`,
                method: 'GET',
                success: function(get_data) {
                    console.log(get_data);

                    let tanggal = get_data[0]['tanggal_penjualan'];
                    let tanggal_belum = new Date(tanggal);
                    let tangga_fix = tanggal_belum.toISOString().split('T')[0];
                    // console.log(get_data[0]['user'][0]);
                    $('#tanggal_edit').val(tangga_fix);
                    if (get_data[0]['id_user'] != undefined) {
                        $('#nama_anggota_edit').val(get_data[0]['nama_user']);
                        $('#poin_edit').val(get_data[0]['poin_user']);
                        $('#credit_edit').val(get_data[0]['credit_user']);
                        $('#id_pelanggan_edit').val(get_data[0]['id_user']);
                        $('#id_anggota_edit').val(get_data[0]['id_user']);
                    } else {
                        $('#nama_anggota_edit').val('');
                        $('#poin_edit').val('');
                        $('#credit_edit').val('');
                        $('#id_pelanggan_edit').val('');
                        $('#id_anggota_edit').val('');
                    }


                    $('#table_kasir_edit tbody').empty();

                    data.forEach(value => {
                        // console.log(value);
                        if (value['data_id'] == row) {
                            // console.log('ya')
                            let i = 1;
                            get_data.forEach(value => {

                                console.log(value);
                                let newRow = `
                            <tr>
                                <td class="text-bold-500">
                                    <a href="#" class="btn btn-outline-warning"
                                        name="edit_row" onclick="editRowEdit(this)"
                                        data-id="${i}"
                                        data-value="${value['id_barang']}"
                                        id="edit_id_product">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="#" class="btn btn-outline-danger"
                                        name="delete_row"
                                        onclick="deleteRowEdit(this)">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                                <td class="text-bold-500">
                                    ${value['id_barang']}
                                </td>
                                <td class="text-bold-500">
                                    ${value['kategori']}
                                </td>
                                <td class="text-bold-500">
                                    ${value['nama_product']}
                                </td>
                                <td class="text-bold-500">
                                    ${value['jumlah_barang']}
                                </td>
                                <td class="text-bold-500">
                                    ${value['harga_jual']}
                                </td>
                                <td class="text-bold-500">
                                    ${value['harga_akhir']}
                                </td>
                            </tr>
                        `;

                                $('#table_kasir_edit tbody').append(newRow);
                                i++;
                            })
                        }
                    })

                }
            })
        }


        $('#metode_pembayaran_edit').on('click', function(e) {
            const metode_pembayaran = e.target.value;
            let id_pelanggan = $('#id_pelanggan_edit').val();

            if (!metode_pembayaran == 'metode_pembayaran_edit') {
                $('#btn_save_edit').attr('hidden', true);
            }
            if (!id_pelanggan) {
                $('#option_kredit_edit').attr('hidden', true);
                $('#btn_save_edit').attr('hidden', false);
            } else {
                $('#option_kredit_edit').attr('hidden', false);
                $('#btn_save_edit').attr('hidden', false);
            }

            if (metode_pembayaran == 'tunai') {

                $('#isTunai_edit').attr('hidden', false);
            } else if (metode_pembayaran == 'kredit') {
                $('#isTunai_edit').attr('hidden', true);
                $('#uang_bayar_edit').val('');
                $('#kembalian_edit').val('');
            }
        })

        // $('#id_pelanggan').on('change', function(e) {
        //     var id_pelanggan = e.target.value;
        //     $.ajax({
        //         url: `/penjualan/get-id-anggota/${id_pelanggan}`,
        //         method: 'GET',
        //         success: function(data) {
        //             $('#id_anggota').val(data.id);
        //             $('#nama_anggota').val(data.name);
        //             $('#poin').val(data.poin);
        //             $('#credit').val(data.credit);
        //         },
        //         error: function() {

        //             $('#id_anggota').val('');
        //             $('#nama_anggota').val('');
        //             $('#poin').val('');
        //             $('#credit').val('');
        //         }
        //     })

        // });

        $('#tukar_poin_edit').on('click', function() {
            $('#jumlah_poin_edit').val($('#poin_edit').val())
            // alert($('#jumlah_poin').val())
        })

        $('#hitung_sub_total_edit').on('click', function(e) {
            e.stopPropagation();

            var harga_total = [];
            var id_anggota = $('#id_pelanggan_edit').val();
            var poin = $('#jumlah_poin_edit').val() * 3000;
            var metode_pembayaran = $('#metode_pembayaran_edit').val();


            $('#table_kasir_edit tbody tr').each(function() {
                var harga_akhir = $(this).find('td:eq(6)')[0]['innerText'];
                harga_total.push({
                    harga_akhir: harga_akhir
                });
            });
            let sum = 0;

            harga_total.forEach(value => {
                sum += parseInt(value['harga_akhir']);
            });
            console.log(harga_total, sum);


            // console.log(metode_pembayaran);
            if (metode_pembayaran) {
                // alert(metode_pembayaran);
                if (metode_pembayaran == 'Pilih Metode Pembayaran') {
                    $('#sub_total_edit').val(sum - poin);
                } else if (metode_pembayaran == 'kredit') {
                    $('#sub_total_edit').val((sum - poin) + ((sum - poin) * 0.05));
                } else {
                    $('#sub_total_edit').val(sum - poin);
                }
            } else {
                $('#sub_total_edit').val(sum - poin);
            }

            if (id_anggota) {
                $('#diskon_edit').val(10);
                $('#hasil_diskon_edit').val(sum * 0.1);

                if ($('#sub_total_edit').val() >= 100000) {
                    $('#tambahan_poin_edit').val(1);
                } else {
                    $('#tambahan_poin_edit').val(0);
                }
                $('#nominal_bayar_edit').val($('#sub_total_edit').val() - $('#hasil_diskon_edit').val())
            } else {
                $('#diskon_edit').val('');
                $('#hasil_diskon_edit').val('');
                $('#nominal_bayar_edit').val(sum - poin)
            }


            // console.log(harga_total, `sum: ${sum}`);
            $('#uang_bayar_edit').attr('readonly', false);


        })


        $('#uang_bayar_edit').on('change', function() {

            var uang_bayar = $('#uang_bayar_edit').val();
            var nominal_bayar = $('#nominal_bayar_edit').val();
            // console.log(`UANG BAYAR: ${uang_bayar} NOMINAL BAYAR ${nominal_bayar}`)
            let checkUang = uang_bayar - nominal_bayar;

            if (checkUang < 0) {
                alert('Uang kurang ' + (checkUang))
                $('#kembalian_edit').val('');
            } else {
                $('#kembalian_edit').val(checkUang);
            }
        })

        $('#btn_save_edit').on('click', function() {
            let data = [];
            let data_detail = []

            $('#table_kasir_edit tbody tr').each(function() {
                const id_barang = $(this).find('td:eq(1)')[0]['innerText'];
                const kategori = $(this).find('td:eq(2)')[0]['innerText'];
                const nama_barang = $(this).find('td:eq(3)')[0]['innerText'];
                const jumlah_barang = $(this).find('td:eq(4)')[0]['innerText'];
                const harga_jual = $(this).find('td:eq(5)')[0]['innerText'];
                const harga_akhir = $(this).find('td:eq(6)')[0]['innerText'];
                // console.log(id_barang, kategori, nama_barang, jumlah_barang, harga_jual, harga_akhir)
                data_detail.push({
                    id_barang,
                    kategori,
                    nama_barang,
                    jumlah_barang,
                    harga_jual,
                    harga_akhir
                });



            });

            const {
                id_pelanggan_edit,
                tanggal_edit,
                id_anggota_edit,
                nama_anggota_edit,
                poin_edit,
                tukar_poin_edit,
                credit_edit,
                jumlah_poin_edit,
                sub_total_edit,
                diskon_edit,
                hasil_diskon_edit,
                nominal_bayar_edit,
                uang_bayar_edit,
                kembalian_edit,
                metode_pembayaran_edit,
                tambahan_poin_edit,
                id_penjualan_edit
            } = $('#form_kasir_edit').serializeArray().reduce((obj_edit, item_edit) => {
                obj_edit[item_edit.name] = item_edit.value;
                // console.log(obj_edit)
                return obj_edit;
            }, {});

            data.push({
                id_pelanggan_edit,
                tanggal_edit,
                id_anggota_edit,
                nama_anggota_edit,
                poin_edit,
                tukar_poin_edit,
                credit_edit,
                jumlah_poin_edit,
                sub_total_edit,
                diskon_edit,
                hasil_diskon_edit,
                nominal_bayar_edit,
                uang_bayar_edit,
                kembalian_edit,
                metode_pembayaran_edit,
                tambahan_poin_edit,
                id_penjualan_edit
            });
            // console.log(data);


            $.ajax({
                url: '/penjualan/update',
                type: 'POST',
                dataType: "json",
                data: {
                    data: data,
                    data_detail: data_detail,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    _url = `/penjualan/print/${response.data}`
                    // window.open(_url, '_blank');
                    location.href = _url;
                },
                error: function(xhr, status, error) {
                    console.log(error, xhr, status);
                }
            })

            // location.reload();
        })

        function tambahBarisEdit() {
            var stok = $('#stok_edit').val();
            var harga_jual = $('#harga_jual_edit').val();
            var jumlah_barang = $('#jumlah_barang_edit').val();
            var harga_akhir = $('#harga_akhir_edit').val();
            var id_barang = $('#id_barang_edit').val();
            var for_id_product = $('#edit_id_product').val();
            // console.log(stok, harga_jual, harga_akhir, jumlah_barang, id_barang);
            let data_bs_value = [];
            $('#table_kasir_edit tbody tr').each(function() {
                const data_bs = $(this).find('td:eq(0)')[0]['firstElementChild']['attributes'][4]['nodeValue'];

                // console.log(data_bs);
                data_bs_value.push({
                    data_bs: data_bs
                });

            });
            console.log(data_bs_value.length);
            let data_bs_value_fix = data_bs_value.length + 1;
            // console.log(data_bs_value_fix)
            if (harga_akhir) {
                $.ajax({
                    url: `/penjualan/get-id-product/${id_barang}`,
                    method: 'GET',
                    success: function(data) {
                        // var lastDataId = $('table_kasir_edit tbody tr:last-child')
                        // console.log(lastDataId)
                        var buttons = document.querySelectorAll("a.btn");

                        // Tambahkan event listener ke setiap elemen <a>
                        buttons.forEach(function(button) {
                            button.addEventListener("click", function(event) {
                                var dataId = this.getAttribute("data-id");

                                // Lakukan operasi apa pun dengan data-id yang diperoleh
                                // console.log(dataId);
                            });
                        });

                        var newRow = `
                                <tr>
                                    <td class="text-bold-500">
                                        <a href="#" class="btn btn-outline-warning"
                                            name="edit_row" onclick="editRowEdit(this)"
                                            data-id="${data_bs_value_fix}"
                                            data-value="${for_id_product}"
                                            id="edit_id_product">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="#" class="btn btn-outline-danger"
                                            name="delete_row"
                                            onclick="deleteRowEdit(this)">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                    <td class="text-bold-500">
                                        ${id_barang}
                                    </td>
                                    <td class="text-bold-500">
                                        ${data.kategori}
                                    </td>
                                    <td class="text-bold-500">
                                        ${data.nama}
                                    </td>
                                    <td class="text-bold-500">
                                        ${jumlah_barang}
                                    </td>
                                    <td class="text-bold-500">
                                        ${data.harga}
                                    </td>
                                    <td class="text-bold-500">
                                        ${harga_akhir}
                                    </td>
                                </tr>
                            `;
                        $('#table_kasir_edit tbody tr').each(function() {
                            const id_barang_table = $(this).find('td:eq(1)')[0]['innerText'];
                            const ini = $(this)[0];

                            if (id_barang == id_barang_table) {
                                ini.remove();
                                $('#table_kasir_edit tbody').append(newRow);
                            }
                        });
                    }
                })
            }
        }


        function deleteRowEdit(btn) {
            var row = btn.closest('tr');
            row.remove();
        }

        function editRowEdit(btn) {
            var row = btn.getAttribute('data-id');

            var for_id_barang = btn.getAttribute('data-value');
            // console.log(for_id_barang);
            // console.log(row);
            let data = [];
            let stok = [];

            $('#table_kasir_edit tbody tr').each(function() {
                let id_barang = $(this).find('td:eq(1)')[0]['innerText'];
                let kategori = $(this).find('td:eq(2)')[0]['innerText'];
                let nama_barang = $(this).find('td:eq(3)')[0]['innerText'];
                let jumlah_barang = $(this).find('td:eq(4)')[0]['innerText'];
                let harga_jual = $(this).find('td:eq(5)')[0]['innerText'];
                let harga_akhir = $(this).find('td:eq(6)')[0]['innerText'];
                // console.log('iki: ' + $(this).find('td:eq(4)')[0]['innerText'])
                // console.log(id_barang, kategori, nama_barang, jumlah_barang, harga_jual, harga_akhir)
                if (id_barang == for_id_barang) {
                    data.push({
                        id_barang,
                        kategori,
                        nama_barang,
                        jumlah_barang,
                        harga_jual,
                        harga_akhir
                    });
                    stok.push({
                        jumlah_barang
                    })
                }
            });
            let total_array = data.length;
            // console.log(data, `IKI: ${data.length == 0 ? 0 : data.length - 1}`);
            let data_final = [];
            let sum_stok = 0;
            stok.forEach(value => {
                sum_stok += parseInt(value['jumlah_barang']);
            })
            // console.log(sum_stok);


            // console.log(data);



            // var stok = $('#stok_edit').val(sum_stok - data[0]['jumlah_barang']);
            // var harga_jual = $('#harga_jual_edit').val(data[0]['harga_jual']);
            // var jumlah_barang = $('#jumlah_barang_edit').val(data[0]['jumlah_barang']);
            // var harga_akhir = $('#harga_akhir_edit').val(data[0]['harga_akhir']);
            // var id_barang = $('#id_barang_edit').val(data[0]['id_barang']);
            $.ajax({
                url: `penjualan/get-id-product/${for_id_barang}`,
                method: 'GET',
                success: function(get_data) {
                    let id_barang_iki = 0
                    data.forEach(value => {
                        // console.log(value['id_barang'], for_id_barang);
                        // sum_stok += parseInt(value['jumlah_barang']);
                        if (value['id_barang'] == for_id_barang) {
                            let sum_stok = 0;
                            // console.log(for_id_barang, value);
                            id_barang_iki = value['id_barang'];
                            stok.forEach(value => {
                                sum_stok += parseInt(value['jumlah_barang']);
                            })

                            console.log(data, value['jumlah_barang'])
                            $('#stok_edit').val(get_data.stok - sum_stok);
                            $('#harga_jual_edit').val(value['harga_jual']);
                            $('#jumlah_barang_edit').val(value['jumlah_barang']);
                            $('#harga_akhir_edit').val(value['harga_akhir']);
                            $('#id_barang_edit').val(value['id_barang']);

                            let stok_edit = $('#stok_edit').val();
                            console.log(stok_edit);
                        }
                    });
                    // console.log(id_barang_iki)
                    // delete.remove();
                    $('#edit_id_product').val(id_barang_iki);
                }
            })
        }
        $('#jumlah_barang_edit').on('change', function(e) {
            var checkDataDouble = [];
            let id_product_edit = $('#id_barang_edit').val();
            $('#table_kasir_edit tbody tr').each(function() {
                var jumlah_barang = $(this).find('td:eq(4)')[0][
                    'innerText'
                ];
                var id_barang = $(this).find('td:eq(1)')[0][
                    'innerText'
                ];

                checkDataDouble.push({
                    jumlah_barang: jumlah_barang,
                    id_barang: id_barang
                });
            });
            let sum = 0;
            let data_id_barang = []
            checkDataDouble.forEach(value => {
                if (parseInt(value['id_barang']) == id_product_edit) {
                    sum += parseInt(value['jumlah_barang']);
                }
                data_id_barang.push({
                    id_barang: value['id_barang'],
                    jumlah_barang: sum
                });
            });
            console.log(sum, data_id_barang)
            $.ajax({
                url: `penjualan/get-id-product/${id_product_edit}`,
                method: 'GET',
                success: function(get_data) {
                    console.log(get_data, id_product_edit);
                    if (get_data.id == id_product_edit) {
                        let sum_stok = 0;
                        var stok_awal = get_data.stok - sum;
                        console.log(stok_awal);
                        var jumlah_barang = e.target.value;
                        var stok_final = stok_awal - jumlah_barang;
                        var harga_akhir = get_data.harga * jumlah_barang;
                        $('#stok_edit').val(stok_final);
                        $('#harga_akhir_edit').val(harga_akhir);
                    }
                    // });
                }
            })

        })
    </script>
