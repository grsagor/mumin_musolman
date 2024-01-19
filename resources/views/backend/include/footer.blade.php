
</div>
</div>
<script src="{{ asset('assets/js/backend/bootstrap.bundle.min.js')}}" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/backend/scripts.js')}}"></script>
<script src="{{ asset('assets/js/backend/jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/backend/toastr.min.js')}}"></script>
<script src="{{ asset('assets/js/backend/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>

<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

{{-- <script src="{{ asset('assets/js/backend/select2.min.js')}}" ></script> --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="{{ asset('assets/js/backend/validator.js')}}" ></script>


<script>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            $.toast({
                heading: 'Error',
                text: "{{ $error }}",
                position: 'top-center',
                icon: 'error'
            })
        @endforeach
    @endif

    @if (session()->has('success'))
        $.toast({
            heading: 'Success',
            text: "{{ session()->get('success') }}",
            position: 'top-center',
            icon: 'success'
        })
    @endif


    function previewFile(input, preview){
        var file = $("#"+input+"").get(0).files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $("#"+preview+"").attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }

    function initSummerNote() {
        $('.tinymceText').summernote({
            height: 200,
        });
    }

    initSummerNote();


    $('.select2').select2();


    $(document).on('click', '.flag-select', function(e) {
        e.preventDefault();
        let language = $(this).attr('data-language');
        $.ajax({
            url: "{{ url('admin/setting/change-language') }}",
            type: "Get",
            data: {
                language: language,
            },
            success: function (response) {
                window.location.reload();
            }
        })
    });

</script>
    @stack('footer')
</body>
</html>
