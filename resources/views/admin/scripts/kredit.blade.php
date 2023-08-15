<script>
    function clearForm() {
        $('#id_anggota, #nama, #alamat, #credit, #total_credit, #jumlah_bayar, #sisa, #keterangan')
            .val('');
    }
    $('#id_anggota').on('change', function(e) {
        let id_anggota = e.target.value;
        $.ajax({
            url: `/pembayaran-kredit/get-user-id/${id_anggota}`,
            method: 'GET',
            success: (data) => {
                if (data.id == undefined) {
                    alert('data tidak ditemukan');
                    $('#jumlah_bayar').attr('readonly', true);
                    $('#bayar').attr('hidden', true);
                    clearForm();
                } else if (data.credit > 0) {
                    $('#nama').val(data.name);
                    $('#alamat').val(data.address);
                    $('#credit, #total_credit').val(data.credit);
                    $('#jumlah_bayar').attr('readonly', false);
                    $('#bayar').attr('hidden', true);
                } else {
                    clearForm();
                    $('#jumlah_bayar').attr('readonly', true);
                    $('#bayar').attr('hidden', true);
                    alert('Anggota tidak memiliki Kredit');

                }

            },
            error: function() {
                $('#jumlah_bayar').attr('readonly', true);
                $('#bayar').attr('hidden', true);
                clearForm();
            }
        })
    })

    $('#jumlah_bayar').on('change', function(e) {
        let jumlahBayar = parseInt($(this).val());
        if (isNaN(jumlahBayar)) {
            $('#bayar').attr('hidden', true);
        } else {
            $('#bayar').attr('hidden', false);
        }
        let total_kredit = $('#total_credit').val();
        console.log(jumlahBayar)
        if (jumlahBayar > total_kredit) {
            $('#jumlah_bayar').val('');
            alert('Uang Kelebihan');
        } else {
            let sisa = total_kredit - jumlahBayar;
            $('#sisa').val(sisa)

            if (sisa != 0) {
                $('#keterangan').val('Belum Lunas')
            } else {
                $('#keterangan').val('Lunas')
            }
        }
    })

    $('#bayar').on('click', function() {
        let id_anggota = $('#id_anggota').val();
        let nama = $('#nama').val();
        let alamat = $('#alamat').val();
        let credit = $('#credit').val();
        let total_credit = $('#total_credit').val();
        let jumlah_bayar = $('#jumlah_bayar').val();
        let sisa = $('#sisa').val();
        let keterangan = $('#keterangan').val();
        $.ajax({
            url: '/pembayaran-kredit',
            type: 'POST',
            dataType: "json",
            data: {
                data: {
                    id_anggota,
                    nama,
                    alamat,
                    credit,
                    total_credit,
                    jumlah_bayar,
                    sisa,
                    keterangan,
                },
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                _url =
                    `/pembayaran-kredit/print/${response.data}`
                // window.open(_url, '_blank');
                location.href = _url;
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })
    })
</script>
