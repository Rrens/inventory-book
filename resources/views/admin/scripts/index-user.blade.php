<script>
    $('#choose_user').on('change', function(e) {
        let data = e.target.value;
        if (data == 1) {
            $('#type_anggota').attr('hidden', false);
            $('#password').attr('hidden', true);
        } else {
            $('#password').attr('hidden', false);
            $('#type_anggota').attr('hidden', true);
        }
    })

    $('#choose_user_edit').on('change', function(e) {
        let data = e.target.value;
        if (data == 1) {
            $('#type_anggota_edit').attr('hidden', false);
        } else {
            $('#type_anggota_edit').attr('hidden', true);
        }
    })

    // NOT BELOW
</script>
