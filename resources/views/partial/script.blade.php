<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <script>
    toastr.options = {
            "progressBar" : true,
            "closeButton" : true,
    }
    @if(Session::has('success'))
        toastr.success("{{ session('success') }}")
    @endif
  </script>
  <script>
    toastr.options = {
            "progressBar" : true,
            "closeButton" : true,
    }
    @if(Session::has('error'))
        toastr.error("{{ session('error') }}")
    @endif
  </script>
