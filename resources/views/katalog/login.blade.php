<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset("css/style.css") }}">
    <title>Login</title>
  </head>
  <body class="vh-100 d-flex justify-content-between align-items-center">


    <div class="row mx-auto">
        @if(session()->has("LoginError"))
        <div class="col-md-8 mx-auto">
            <div class="alert alert-danger d-flex justify-content-between align-items-center" role="alert">
                {{ session("LoginError") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert">
                    
                </button>
            </div>
        </div>
        @endif
        
    
        <div class="card mx-auto shadow-lg px-2 py-3" style="width: 18rem;">
            <div class="card-header bg-white border-0">
                <h3 class="text-center fw-bold fs-2">Login</h3>
            </div>
            <div class="card-body border-0">
                <form method="post" action="/katalog/login">
                    @csrf
                    <div class="mb-3 my-2">
                        <input type="email" class="form-control shadow-sm @error("email") is-invalid @enderror" id="email" name="email" placeholder="Masukkan Email Anda" style="height:50px;">
                        @error("email")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 my-3">
                        <input type="password" class="form-control shadow-sm @error("password") is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password Anda" style="height:50px;">
                        @error("password")
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="ingatSaya" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Ingat Saya</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3 shadow-sm">Login</button>
                </form>
            </div>
        </div>
        
        </div>
    </div>

    

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
   
  </body>
</html>