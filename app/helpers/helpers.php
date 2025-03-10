<?php

if (! function_exists('show_toast')) {
    function show_toast($type, $message)
    {
        return "
            <script>
                Swal.fire({
                    toast: true,
                    position: 'bottom-end',
                    icon: '{$type}',
                    title: '{$message}',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            </script>
        ";
    }
}
