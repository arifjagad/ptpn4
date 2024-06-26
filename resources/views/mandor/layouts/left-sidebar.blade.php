<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="#" class="logo logo-light">
        <span class="logo-lg">
            <img src="/images/logo-ptpn-iv-regional-2.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="/images/logo-ptpn-iv-regional-1-sm.png" alt="small logo">
        </span>
        {{-- <h5 class="text-white mt-3 mb-2">PTPN IV REGIONAL I</h5> --}}
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="#">
                <img src="/images/users/avatar-1.jpg" alt="user-image" height="42" class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Tosha Minner</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/dashboard') }}" class="side-nav-link">
                    <i class="ri-home-4-line"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <li class="side-nav-title">Data PTPN IV</li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/karyawan') }}" class="side-nav-link">
                    <i class="ri-group-line"></i>
                    <span> Karyawan Tamu </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/kegiatan') }}" class="side-nav-link">
                    <i class="ri-calendar-event-line"></i>
                    <span> Daftar Kegiatan </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/kuesioner') }}" class="side-nav-link">
                    <i class="ri-booklet-line"></i>
                    <span> Data Kuesioner </span>
                </a>
            </li>

            <li class="side-nav-title">Data Mandor</li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/supir') }}" class="side-nav-link">
                    <i class="ri-group-line"></i>
                    <span> Daftar Supir </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ url('mandor/mobil') }}" class="side-nav-link">
                    <i class="ri-roadster-line"></i>
                    <span> Daftar Mobil </span>
                </a>
            </li>

        </ul>
        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>
</div>
<!-- ========== Left Sidebar End ========== -->
