<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Sistem Informasi RAB ITERA</title>
    <link rel="icon" href="favicon.ico">
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="<?= url('/css/simplebar.css') ?>">
    <!-- Fonts CSS -->
    <link
        href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="<?= url('/css/feather.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/select2.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/jquery.steps.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/jquery.timepicker.css') ?>">
    <link rel="stylesheet" href="<?= url('/css/quill.snow.css') ?>">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="<?= url('/css/daterangepicker.css') ?>">
    <!-- App CSS -->
    <link rel="stylesheet" href="<?= url('/css/app-light.css') ?>" id="lightTheme">
    <link rel="stylesheet" href="<?= url('/css/app-dark.css') ?>" id="darkTheme" disabled>
    <!-- iziToast -->
    <link rel="stylesheet" href="<?= url('/css/iziToast.min.css') ?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= url('/css/dataTables.bootstrap4.css') ?>">

    @yield('css')
</head>

<body class="vertical light collapsed">

    <div class="wrapper">
        @include('template.navbar')
        @include('template.sidebar')
        @yield('content')

        <!-- Settings Modal -->
        <div id="modal-settings-container"></div>
    </div>

    <script>
        const site_url =  "{{ url('/')}}"
        const site_url_api =  "{{ url('api')}}"
    </script>
    <script src="<?= url('/js/jquery.min.js') ?>"></script>
    <script src="<?= url('/js/popper.min.js') ?>"></script>
    <script src="<?= url('/js/bootstrap.min.js') ?>"></script>
    <script src="<?= url('/js/simplebar.min.js') ?>"></script>
    <script src="<?= url('/js/daterangepicker.js') ?>">
    </script>
    <script src="<?= url('/js/jquery.stickOnScroll.js') ?>">
    </script>
    <script src=" <?=url('/js/tinycolor-min.js') ?>">
    </script>
    <script src="<?= url('/js/config.js') ?>"></script>
    <script src="<?= url('/js/d3.min.js') ?>"></script>
    <script src="<?= url('/js/gauge.min.js') ?>"></script>
    <script src="<?= url('/js/jquery.sparkline.min.js') ?>"></script>
    <script src="<?= url('/js/apexcharts.min.js') ?>"></script>
    <script src="<?= url('/js/apexcharts.custom.js') ?>"></script>
    <script src="<?= url('/js/jquery.mask.min.js') ?>">
    </script>
    <script src=" <?=url('/js/select2.min.js') ?>
        ">
    </script>
    <script src="<?= url('/js/jquery.validate.min.js') ?>
        ">
    </script>
    <script src="<?= url('/js/jquery.timepicker.js') ?>
        ">
    </script>
    <script src="<?= url('/js/quill.min.js') ?>
        ">
    </script>
    <script src="<?= url('/js/apps.js') ?>"></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script> -->
    <!-- iziToast -->
    <script src="<?= url('/js/iziToast/iziToast.min.js') ?>" type="text/javascript"></script>
    <!-- Datatables -->
    <script src="<?= url('/js/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= url('/js/dataTables.bootstrap4.min.js') ?>"></script>

    <script src="<?= url('/js/helper/ajax.js') ?>"></script>
    <script src="<?= url('/js/helper/form-input.js') ?>"></script>
    <script src="<?= url('/js/helper/form-validation.js') ?>"></script>
    <script src="<?= url('/js/helper/datatables.js') ?>"></script>
    <script src="<?= url('/js/helper/toast.js') ?>"></script>
    <script src="<?= url('/js/helper/modal.js') ?>"></script>

    @yield('script')
</body>

</html>