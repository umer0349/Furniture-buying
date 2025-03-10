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
                    timer: 1500,
                    timerProgressBar: true
                });
            </script>
        ";
    }
    if (! function_exists('delete_confirm')) {
        function delete_confirm($formId)
        {
            return "
                <script>
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This action cannot be undone!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('{$formId}').submit();
                        }
                    });
                </script>
            ";
        }
    }
    
}
