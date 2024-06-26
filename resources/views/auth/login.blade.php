<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Log In'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('/images/favicon-ptpn.ico') }}">
</head>

<body class="authentication-bg position-relative">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <span class="logo-lg">
                                <img src="/images/logo-ptpn-iv-regional-2.png" alt="logo">
                            </span>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
                                {{-- <p class="text-muted mb-4">Enter your email address and password to access admin panel.</p> --}}
                            </div>

                            <form method="POST" action="{{ route('login') }}">
                                @if (sizeof($errors) > 0)
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li class="text-danger">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @csrf
                                <div class="mb-3">
                                    <label for="identifier" class="form-label">Email address</label>
                                    <input class="form-control" type="text" id="identifier" required="" placeholder="" name="identifier">
                                </div>

                                <div class="mb-3">
                                    {{-- <a href="{{ route('second', ['auth', 'recoverpw']) }}" class="text-muted float-end fs-12">Forgot your password?</a> --}}
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                                        <div class="input-group-text" data-password="false">
                                            <spy class="password-eye"></spy>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mb-0 text-center">
                                    <button class="btn btn-primary" type="submit"> Log In </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted bg-body">Don't have an account? <a href="{{ route('register') }}" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Sign Up</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt fw-medium">
        <span class="bg-body">
            <script>
                document.write(new Date().getFullYear())
            </script> © PTPN IV REGIONAL I
        </span>
    </footer>
    @vite(['resources/js/app.js'])
    @include('layouts.shared/footer-script')
</body>

</html>
