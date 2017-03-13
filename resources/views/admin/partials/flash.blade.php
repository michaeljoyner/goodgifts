@if(session()->has('flash_message'))
    <script>
        swal({
            type: "{{ session('flash_message.type')  }}",
            title: "{{ session('flash_message.title') }}",
            text: "{{ session('flash_message.text') }}",
            timer: 1500,
            showConfirmButton: false
        });
    </script>
@endif

@if(count($errors) > 0)
    <script>
        swal({
            type: "error",
            title: "There was a problem with your input",
            text: "Some input you entered was not valid. Please check for error messages and try again.",
            showConfirmButton: true
        });
    </script>
@endif