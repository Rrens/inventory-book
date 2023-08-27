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
                // console.log(data['data_buku']['judul'])
                $('#judul_buku').val(data['data_buku']['judul']);
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

    $('#member_name').on('change', function(e) {
        let nama_member = e.target.value;
        let tanggal_pengembalian = $('#tanggal_pengembalian').val();
        $.ajax({
            url: `/admin/peminjaman/get-user-name/${nama_member}`,
            method: 'GET',
            success: (data) => {
                // console.log(data['detail_peminjaman']['buku'][0][
                //     'isbn'
                // ])
                if (tanggal_pengembalian < data['detail_peminjaman']['peminjaman'][0][
                        'tgl_kembali'
                    ]) {
                    $('#denda').val(5000)
                } else {
                    $('#denda').val(0)
                }
                $('#judul').val(data['detail_peminjaman']['buku'][0][
                    'judul'
                ])
                $('#isbn_pengembalian').val(data['detail_peminjaman']['buku'][0][
                    'isbn'
                ])
                $('#tgl_pinjam').val(data['detail_peminjaman']['peminjaman'][0][
                    'tgl_pinjam'
                ])
                $('#tgl_kembali').val(data['detail_peminjaman']['peminjaman'][0][
                    'tgl_kembali'
                ])

                $('#jumlah_buku_pinjam').val(data['detail_riwayat'])


            },
            error: console.log(),
        })
    })
</script>
