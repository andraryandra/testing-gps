@extends('layouts.dashboard')
@section('admin')
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Halaman Utama</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Auth::user()->name ?? '' }}
                        ({{ Auth::user()->roles[0]['name'] ?? '' }})</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2 row-cols-xxl-4">
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Orders</p>
                            <h4 class="">8,542</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 16% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Total Views</p>
                            <h4 class="">12.5M</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-danger">- 3.4% <i class="bi bi-arrow-down"></i></p>
                            <div id="chart2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Revenue</p>
                            <h4 class="">$64.5K</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 24% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart3"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card overflow-hidden radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-stretch justify-content-between overflow-hidden">
                        <div class="w-50">
                            <p>Customers</p>
                            <h4 class="">25.8K</h4>
                        </div>
                        <div class="w-50">
                            <p class="mb-3 float-end text-success">+ 8.2% <i class="bi bi-arrow-up"></i></p>
                            <div id="chart4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-12 col-lg-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Revenue</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart5"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">By Device</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i
                                    class="bi bi-three-dots"></i></div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 g-3 mt-2 align-items-center">
                        <div class="col-lg-7 col-xl-7 col-xxl-8">
                            <div class="by-device-container">
                                <div class="piechart-legend">
                                    <h2 class="mb-1">85%</h2>
                                    <h6 class="mb-0">Total Visitors</h6>
                                </div>
                                <canvas id="chart6"></canvas>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-5 col-xxl-4">
                            <div class="">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center justify-content-between border-0">
                                        <i class="bi bi-display-fill me-2 text-primary"></i> <span>Desktop -
                                        </span> <span>15.2%</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between border-0">
                                        <i class="bi bi-phone-fill me-2 text-success"></i> <span>Mobile -
                                        </span> <span>62.3%</span>
                                    </li>
                                    <li class="list-group-item d-flex align-items-center justify-content-between border-0">
                                        <i class="bi bi-tablet-landscape-fill me-2 text-orange"></i>
                                        <span>Tablet - </span> <span>22.5%</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->

    <div class="row">
        <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Traffic Source</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart7" class=""></div>
                    <div class="traffic-widget">
                        <div class="progress-wrapper mb-3">
                            <p class="mb-1">Social <span class="float-end">8,475</span></p>
                            <div class="progress rounded-0" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%;">
                                </div>
                            </div>
                        </div>
                        <div class="progress-wrapper mb-3">
                            <p class="mb-1">Direct <span class="float-end">7,989</span></p>
                            <div class="progress rounded-0" style="height: 8px;">
                                <div class="progress-bar bg-pink" role="progressbar" style="width: 65%;">
                                </div>
                            </div>
                        </div>
                        <div class="progress-wrapper mb-0">
                            <p class="mb-1">Search <span class="float-end">6,359</span></p>
                            <div class="progress rounded-0" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 50%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="card radius-10 border shadow-none mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Messages</p>
                                    <h4 class="mb-0 text-pink">289</h4>
                                </div>
                                <div class="dropdown ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                                        data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else
                                                here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="chart8"></div>
                        </div>
                    </div>
                    <div class="card radius-10 border shadow-none mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">Total Posts</p>
                                    <h4 class="mb-0 text-success">489</h4>
                                </div>
                                <div class="dropdown ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                                        data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else
                                                here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="chart9"></div>
                        </div>
                    </div>
                    <div class="card radius-10 border shadow-none mb-0">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="">
                                    <p class="mb-1">New Tasks</p>
                                    <h4 class="mb-0 text-info">149</h4>
                                </div>
                                <div class="dropdown ms-auto">
                                    <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer"
                                        data-bs-toggle="dropdown"><i class="bi bi-three-dots fs-4"></i>
                                    </div>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else
                                                here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="chart10"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12 col-xl-4 d-flex">
            <div class="card radius-10 w-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <h6 class="mb-0">Visitors</h6>
                        <div class="fs-5 ms-auto dropdown">
                            <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown">
                                <i class="bi bi-three-dots"></i>
                            </div>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="chart11" class=""></div>
                    <div class="d-flex align-items-center gap-5 justify-content-center mt-3 p-2 radius-10 border">
                        <div class="text-center">
                            <h3 class="mb-2 text-primary">8,546</h3>
                            <p class="mb-0">New Visitors</p>
                        </div>
                        <div class="border-end sepration"></div>
                        <div class="text-center">
                            <h3 class="mb-2 text-primary-2">3,723</h3>
                            <p class="mb-0">Old Visitors</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--end row-->
@endsection
