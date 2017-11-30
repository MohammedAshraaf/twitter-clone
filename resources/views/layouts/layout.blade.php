@include('layouts.header')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">


<!-- Main content -->
<section class="content">
    @if (session('alert'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Error!</h4>
            <p>{!! session('alert')!!}</p>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Success!</h4>
            <p>{!! session('success') !!}</p>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4>Warning!</h4>
            <p>{!! session('warning')!!}</p>
        </div>
    @endif
    @yield('content')
</section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

@include('layouts.footer')