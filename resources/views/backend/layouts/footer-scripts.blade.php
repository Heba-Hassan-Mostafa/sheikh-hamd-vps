<!-- Back-to-top -->
<a href="#top" id="back-to-top"><i class="las la-angle-double-up"></i></a>
<!-- JQuery min js -->
<script src="{{ URL::asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap Bundle js -->
<script src="{{ URL::asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Ionicons js -->
<script src="{{ URL::asset('assets/plugins/ionicons/ionicons.js') }}"></script>
<!-- Moment js -->
{{-- <script src="{{ URL::asset('assets/plugins/moment/moment.js') }}"></script> --}}

<!-- Rating js-->
<script src="{{ URL::asset('assets/plugins/rating/jquery.rating-stars.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/rating/jquery.barrating.js') }}"></script>

<!--Internal  Perfect-scrollbar js -->
<script src="{{ URL::asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
{{-- <script src="{{ URL::asset('assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script> --}}
<!--Internal Sparkline js -->
<script src="{{ URL::asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<!-- Custom Scroll bar Js-->
<script src="{{ URL::asset('assets/plugins/mscrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- right-sidebar js -->


<script src="{{ URL::asset('assets/plugins/sidebar/sidebar-rtl.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sidebar/sidebar-custom.js') }}"></script>
<!-- Eva-icons js -->
<script src="{{ URL::asset('assets/js/eva-icons.min.js') }}"></script>
@yield('js')
<!-- Sticky js -->
<script src="{{ URL::asset('assets/js/sticky.js') }}"></script>
<!-- custom js -->
<script src="{{ URL::asset('assets/js/custom.js') }}"></script><!-- Left-menu js-->
<script src="{{ URL::asset('assets/plugins/side-menu/sidemenu.js') }}"></script>
{{-- file manager for ckeditor --}}
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<script>
    @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"
        switch (type) {
            case 'info':
                toastr.info("{{ Session::get('message') }}")
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}")
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}")
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}")
                break;

        }
    @endif
</script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).on("click", "#delete", function(e){
        e.preventDefault();
        var form =  $(this).closest("form");
        var name = $(this).data("name");
           swal({
             title: "Are you Want to delete?",
             text: "Once Delete, This will be Permanently Delete!",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
           .then((willDelete) => {
             if (willDelete) {
                form.submit();
             } else {
               swal("Safe Data!");
             }
           });
       });
</script>



<script>
    function CheckAll(className, elem) {
        var elements = document.getElementsByClassName(className);
        var l = elements.length;

        if (elem.checked) {
            for (var i = 0; i < l; i++) {
                elements[i].checked = true;
            }
        } else {
            for (var i = 0; i < l; i++) {
                elements[i].checked = false;
            }
        }

    }
</script>
<script>
    $(function() {
        let numberLimit = 150;
        $(".limitVal").html(numberLimit);
        $(".error-msg").hide();
        $(".count-limit").keyup(function() {
            $(".counting").text($(this).val().length);
            let x = $(this).val().length;
            if (x >= numberLimit) {
                $(this).css("border", "1px solid red");
                $(this).attr('maxlength', numberLimit)
                $(".error-msg").css("color", "red");
                $(".error-msg").show();
            } else {
                $(".error-msg").hide();
                $(this).css("border", "none");
            }
        })
    })
</script>

@livewireScripts

<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>

{{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-livewire-alert::scripts />
<script src="{{ asset('vendor/livewire-alert/livewire-alert.js') }}"></script>
<x-livewire-alert::flash /> --}}
