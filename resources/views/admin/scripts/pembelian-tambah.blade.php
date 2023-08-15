<script>
    $('#btn_save').on('click', function() {
        let data = [];

        $('#table_tambah tbody tr').each(function() {
            const nama = $(this).find('td:eq(1)')[0]['innerText'];
            const kategori = $(this).find('td:eq(2)')[0]['innerText'];
            const jumlah_barang = $(this).find('td:eq(3)')[0]['innerText'];
            const harga_beli = $(this).find('td:eq(4)')[0]['innerText'];
            const harga_jual = $(this).find('td:eq(5)')[0]['innerText'];
            const total_harga = $(this).find('td:eq(6)')[0]['innerText'];
            const keterangan = $(this).find('td:eq(7)')[0]['innerText'];

            let nama_barang = nama.toUpperCase();

            data.push({
                nama_barang,
                jumlah_barang,
                kategori,
                keterangan,
                harga_beli,
                harga_jual,
                total_harga
            });
        });
        // console.log(data);
        $.ajax({
            url: '/pembelian',
            type: 'POST',
            dataType: "json",
            data: {
                data: data,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                _url = `/pembelian/print/${response.data}`
                // window.open(_url, '_blank');
                location.href = _url;
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })

        // location.reload();
    })

    function tambahBaris() {
        // console.log(nama_barang, kategori, keterangan, harga_beli, harga_jual, total_harga)
        let nama_barang = $('#nama_barang').val();
        let jumlah_barang = $('#jumlah_barang').val();
        let kategori = $('#kategori').val();
        let keterangan = $('#keterangan').val();
        let harga_beli = $('#harga_beli').val();
        let harga_jual = $('#harga_jual').val();
        let total_harga = $('#total_harga').val();

        const newRow = `
                <tr>
                    <td class="text-bold-500">
                        <button class="btn btn-outline-danger" name="delete_row" onclick="deleteRow(this)">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                    <td class="text-bold-500">
                        ${nama_barang}
                    </td>
                    <td class="text-bold-500">
                        ${kategori}
                    </td>
                    <td class="text-bold-500">
                        ${jumlah_barang}
                    </td>
                    <td class="text-bold-500">
                        ${harga_beli}
                    </td>
                    <td class="text-bold-500">
                        ${harga_jual}
                    </td>
                    <td class="text-bold-500">
                        ${total_harga}
                    </td>
                    <td class="text-bold-500">
                        ${keterangan}
                    </td>
                </tr>
        `

        $('#table_tambah tbody').append(newRow);

    }

    function deleteRow(btn) {
        var row = btn.closest('tr');
        row.remove();
    }

    $('#harga_beli').on('change', function(e) {
        let harga_beli = e.target.value;
        let jumlah_barang = $('#jumlah_barang').val();


        $('#total_harga').val(harga_beli * jumlah_barang);
        $('#tambah_tabel').attr('hidden', false);
        // alert(harga_beli);
        // console.log(harga_beli);
    })

    $('#nama_barang').on('change', function(e) {
        let nama_barang = e.target.value;

        $.ajax({
            url: `pembelian/get-product/${nama_barang}`,
            method: 'GET',
            success: function(get_data) {
                // console.log(get_data);
                $('#kategori').val(get_data[0]['product'][0]['kategori']);
                $('#keterangan').val(get_data[0]['pembelian'][0]['keterangan']);
                $('#harga_jual').val(get_data[0]['harga_jual']);
                $('#keterangan').attr('readonly', true);
                $('#harga_jual').attr('readonly', true);

                // var conceptName = $('#aioConceptName').find(":selected").val();

            },
            error: function() {
                // console.log('gaada data');
                $('#kategori').val('');
                $('#keterangan').val('');
                $('#harga_jual').val('');
                $('#keterangan').attr('readonly', false);
                $('#harga_jual').attr('readonly', false);
            }
        })
    })
</script>
