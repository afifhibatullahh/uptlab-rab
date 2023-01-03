<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Login - Sistem Informasi Rencana Anggaran Belanja</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= url(''); ?>/css/simplebar.css">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= url(''); ?>/css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= url(''); ?>/css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= url(''); ?>/css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="<?= url(''); ?>/css/app-dark.css" id="darkTheme" disabled>
</head>

<body class="light ">
    <div class="wrapper vh-100">

        <div class="row align-items-center h-100">
            <form class="col-lg-3 col-md-4 col-10 mx-auto text-center" action="/login/auth" method="POST">
                <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="./index.html">
                    <img src="/assets/images/Logo_ITERA.png" width="100px" alt="">
                </a>
                <h5 class="mb-5">Sistem Rencana Anggaran Belanja <br> UPT Laboratorium <br> Institut Teknologi Sumatera
                </h5>
                @if(count($errors) > 0)
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    <span class="fe fe-minus-circle fe-16 mr-2"></span>{{ $error }}
                </div>
                @endforeach
                @endif

                @if(Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="form-group">
                    <label for="inputEmail" class="sr-only">Email address</label>
                    <input type="email" id="inputEmail" name="email" class="form-control form-control-lg"
                        placeholder="Email address" value="{{ Session::get('email')}}" required="" autofocus="">
                </div>
                <div class="form-group">
                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" name="password" class="form-control form-control-lg"
                        placeholder="Password" required="">
                </div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                <p class="mt-5 mb-3 text-muted">© UPT Laboratorium ITERA 2022</p>
            </form>
        </div>
    </div>
    <script src="<?= url(''); ?>/js/jquery.min.js"></script>
    <script src="<?= url(''); ?>/js/popper.min.js"></script>
    <script src="<?= url(''); ?>/js/moment.min.js"></script>
    <script src="<?= url(''); ?>/js/bootstrap.min.js"></script>
    <script src="<?= url(''); ?>/js/simplebar.min.js"></script>
    <script src="<?= url(''); ?>/js/daterangepicker.js"></script>
    <script src="<?= url(''); ?>/js/jquery.stickOnScroll.js"></script>
    <script src="<?= url(''); ?>/js/tinycolor-min.js"></script>
    <script src="<?= url(''); ?>/js/config.js"></script>
    <script src="<?= url(''); ?>/js/apps.js"></script>
</body>

</html>
</body>

</html>