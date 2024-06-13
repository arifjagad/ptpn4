<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Register'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
</head>

<body class="authentication-bg">

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">
                        <!-- Logo-->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="{{ route('any', 'index') }}ml">
                                {{-- <span><img src="/im>ages/logo.png" alt="logo" height="22"></span> --}}
                                <h3 class="text-white">PTPN IV REGIONAL I</h3>
                            </a>
                        </div>

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">Sign Up</h4>
                            </div>

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input class="form-control" type="text" id="fullname" name="name" placeholder="Enter your name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">Email address</label>
                                    <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="Enter your email">
                                </div>

                                <div class="mb-3">
                                    <label for="user_type" class="form-label">Role</label>
                                    <select class="form-select" name="user_type" id="user_type" required>
                                        <option value="mandor">Mandor</option>
                                        <option value="karyawan pelaksana">Karyawan</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required placeholder="Confirm your password">
                                </div>

                                <div class="mb-3 text-center">
                                    <button class="btn btn-primary" type="submit"> Sign Up </button>
                                </div>

                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted bg-body">Already have account? <a
                                    href="{{ route('any', ['login']) }}"
                                    class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Log In</b></a>
                            </p>
                        </div> <!-- end col-->
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
