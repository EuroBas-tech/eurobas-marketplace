<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/css/bootstrap.min.css" integrity="sha512-fw7f+TcMjTb7bpbLJZlP8g2Y4XcCyFZW8uy8HsRZsH/SwbMw0plKHFHr99DN3l04VsYNwvzicUX/6qurvIxbxw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>
<body>

    <main>
        <form action="{{ route('add-words-to-translations') }}" method="POST">
            @csrf
            <div class="d-flex align-items-center gap-2 m-3">
                <div class="form-group w-75">
                    <input type="text" class="form-control" placeholder="Add a word here" id="word" name="word" required>
                </div>
                <div class="w-25">
                    <button type="submit" class="btn btn-primary">Add To All Languages</button>
                </div>
            </div>
        </form>
    </main>

    

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.7/js/bootstrap.min.js" integrity="sha512-zKeerWHHuP3ar7kX2WKBSENzb+GJytFSBL6HrR2nPSR1kOX1qjm+oHooQtbDpDBSITgyl7QXZApvDfDWvKjkUw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- jQuery (Required for Toastr) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        toastr.options = {
            "positionClass": "toast-top-right", // 👈 This sets it to top right
            "closeButton": true,
            "progressBar": true,
            "timeOut": "5000"
        };
    </script>

    <!-- Toastr Render -->
    {!! Toastr::message() !!}
</body>
</html>
