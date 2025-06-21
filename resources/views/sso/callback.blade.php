<script>
    // kirim token ke parent window dan tutup popup
    if (window.opener) {
        window.opener.postMessage({
            token: "{{ $token }}"
        }, "{{ $target }}");

        window.close();
    } else {
        // Jika tidak ada opener, redirect ke target
        window.location.href = "{{ $target }}";
    }
</script>
