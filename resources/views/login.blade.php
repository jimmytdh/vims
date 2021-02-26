
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ url('/') }}/images/favicon.png" sizes="16x16" type="image/png">
    <meta name="description" content="Vaccine Information Management System"/>

    <title>Login: CSMC Vaccine Information Management System</title>


    <!-- Bootstrap core CSS -->
    <link href="{{ url('/') }}/css/bootstrap.css" rel="stylesheet">
    <link href="{{ url('/') }}/css/register.css" rel="stylesheet">
    <style>
        .alert-circle {
            border-radius: 30px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-lg-10 col-xl-9 mx-auto">
            <div class="card card-signin flex-row my-5">
                <div class="card-img-left d-none d-md-flex">
                    <!-- Background image for card set in CSS! -->
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <img src="{{ url('/') }}/images/logo.png" alt="" width="150">
                    </div>

                    <h5 class="card-title text-center">
                        <span class="font-weight-bold">Vaccine Information<br>Management System</span>
                        <br>
                        <small class="text-muted" style="font-size: 0.7em;">
                            Sign in to start your session
                        </small>
                    </h5>
                    @if(session('error'))
                    <div class="alert alert-danger alert-circle text-center">
                        Login Failed! Please try or register a new account.
                    </div>
                    @endif
                    <form class="form-signin" method="post" action="{{ route('validate.login') }}">
                        {{ csrf_field() }}
                        <div class="form-label-group">
                            <input type="text" name="username" id="inputUserame" class="form-control" placeholder="Username" required autofocus>
                            <label for="inputUserame">Username</label>
                        </div>

                        <div class="form-label-group">
                            <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                            <label for="inputPassword">Password</label>
                        </div>

                        <button class="btn btn-lg btn-success btn-block text-uppercase" type="submit">Login</button>
                        <a class="d-block text-center mt-2 small" href="{{ url('/register') }}/">Don't have account? Register Now!</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
