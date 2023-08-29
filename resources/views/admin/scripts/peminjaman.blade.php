<script>
    $('#id_member').on('change', function(e) {
        let id_anggota = e.target.value;
        $.ajax({
            url: `/admin/peminjaman/get-user-id/${id_anggota}`,
            method: 'GET',
            success: (data) => {
                // console.log(data)
                $('#nama_member').val(data['data_user']['username']);
                $('#member_type').val(data['data_user']['type_anggota'] == 0 ? 'Guru' :
                    'Murid');
                $('#jumlah_pinjam').val(data['detail_riwayat']);
                $('#jumlah_pinjam_belum_kembali').val(data['detail_riwayat_belum']);
            },
        })
    })

    $('#isbn').on('change', function(e) {
        let isbn = e.target.value;
        $.ajax({
            url: `/admin/peminjaman/get-book-id/${isbn}`,
            method: 'GET',
            success: (data) => {
                console.log(data)
                if (data['status'] == 'Failed') {
                    alert(data['keterangan']);

                    $('#judul_buku').val('');
                    $('#isbn').val('');
                } else {
                    $('#judul_buku').val(data['data_buku']['judul']);

                }
                // console.log(data['data_buku']['judul'])
            },
        })
    })

    $('#id_member_edit').on('change', function(e) {
        let id_anggota = e.target.value;
        $.ajax({
            url: `/admin/peminjaman/get-user-id/${id_anggota}`,
            method: 'GET',
            success: (data) => {
                // console.log(data)
                $('#nama_member_edit').val(data['data_user']['username']);
                $('#member_type_edit').val(data['data_user']['type_anggota'] == 0 ? 'Guru' :
                    'Murid');
                $('#jumlah_pinjam_edit').val(data['detail_riwayat']);
                $('#jumlah_pinjam_belum_kembali_edit').val(data['detail_riwayat_belum']);
            },
        })
    })

    $('#isbn_edit').on('change', function(e) {
        let isbn = e.target.value;
        $.ajax({
            url: `/admin/peminjaman/get-book-id/${isbn}`,
            method: 'GET',
            success: (data) => {
                // console.log(data['data_buku']['judul'])
                $('#judul_buku_edit').val(data['data_buku']['judul']);
            },
        })
    })

    $('#isbn_pengembalian').on('change', function(e) {
        let isbn = e.target.value;
        let nama_member = $('#member_name').val()
        $.ajax({
            url: `/admin/pengembalian/get-book-pengembalian/${nama_member}/${isbn}`,
            method: 'GET',
            success: (data) => {
                if (data['status'] == 'Failed') {
                    alert(data['keterangan']);
                    $('#judul').val('')
                    $('#isbn_pengembalian').val('')

                }
                $('#judul').val(data['data_buku']['buku'][0][
                    'judul'
                ])
            },
            error: (error) => {
                console.log(error)
            },
        })
    })

    $('#member_name').on('change', function(e) {
        let nama_member = e.target.value;
        let tanggal_pengembalian = $('#tanggal_pengembalian').val();
        $.ajax({
            url: `/admin/peminjaman/get-user-name/${nama_member}`,
            method: 'GET',
            success: (data) => {
                if (data['status'] == 'Failed') {
                    alert(data['keterangan']);
                    $('#member_name').val('')
                    $('#isbn_pengembalian').attr('readonly', true);
                    $('#tgl_pinjam').val('')
                    $('#tgl_kembali').val('')

                    $('#jumlah_buku_pinjam').val('')
                }
                $('#isbn_pengembalian').attr('readonly', false);
                // console.log(data['detail_peminjaman']['buku'][0][
                //     'isbn'
                // ])
                // $('#judul').val(data['detail_peminjaman']['buku'][0][
                //     'judul'
                // ])
                // $('#isbn_pengembalian').val(data['detail_peminjaman']['buku'][0][
                //     'isbn'
                // ])
                $('#tgl_pinjam').val(data['detail_peminjaman']['peminjaman'][0][
                    'tgl_pinjam'
                ])
                $('#tgl_kembali').val(data['detail_peminjaman']['peminjaman'][0][
                    'tgl_kembali'
                ])

                $('#jumlah_buku_pinjam').val(data['detail_riwayat'])


            },
            error: (error) => {
                // console.log(error)
            },
        })
    })
</script>
