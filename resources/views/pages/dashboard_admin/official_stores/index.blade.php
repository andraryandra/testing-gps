@extends('layouts.dashboard')


@section('admin')



    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tabel Official Store</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    @if (isset($breadcumb['links']))
                        @foreach ($breadcumb['links'] as $link)
                            <li class="breadcrumb-item">
                                <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                            </li>
                        @endforeach
                    @endif
                    @if (isset($breadcumb['current']))
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcumb['current'] }}</li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    @include('layouts.partials.alert-prompt.alert')

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-3 col-xl-2">
                    @can('official-store-create')
                        <a href="{{ route('dashboard.official-store.create') }}" class="btn btn-sm btn-primary mb-3 mb-lg-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah"><i
                                class="bi bi-plus-square-fill mx-1"></i>
                            Tambah Official Store
                        </a>
                    @endcan
                </div>
                <div class="col-lg-9 col-xl-10">
                    <form class="float-lg-end">
                        <div class="row row-cols-lg-auto g-2">
                            <div class="col-12">
                                <a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i
                                        class="bi bi-download"></i>Export</a>
                            </div>
                            <div class="col-12">
                                <a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i
                                        class="bi bi-upload"></i>Import</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <label for="perPage">Search:</label>
                    <div class="ms-auto position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                class="bi bi-search"></i></div>
                        <input class="form-control ps-5" type="text" placeholder="search produts">
                    </div>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form method="GET" action="{{ route('dashboard.official-store.index') }}">
                        <label for="status">Status:</label>
                        <select class="form-select" name="status" onchange="this.form.submit()">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="ALL" {{ $status == 'ALL' ? 'selected' : '' }}>All Status</option>
                            <option value="ACTIVE" {{ $status == 'ACTIVE' ? 'selected' : '' }}>Active</option>
                            <option value="INACTIVE" {{ $status == 'INACTIVE' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <input type="hidden" name="perPage" value="{{ $perPage }}">
                    </form>
                </div>

                <div class="col-lg-2 col-6 col-md-3">
                    <form method="GET" action="{{ route('dashboard.official-store.index') }}">
                        <label for="perPage">Tampilkan:</label>
                        <select id="perPage" name="perPage" class="form-select" onchange="this.form.submit()">
                            <option value="5" {{ request('perPage') == '5' ? 'selected' : '' }}>5</option>
                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == '100' ? 'selected' : '' }}>100</option>
                            <option value="500" {{ request('perPage') == '500' ? 'selected' : '' }}>500</option>
                            <option value="1000" {{ request('perPage') == '1000' ? 'selected' : '' }}>1000</option>
                            <option value="2500" {{ request('perPage') == '2500' ? 'selected' : '' }}>2500</option>
                            <option value="5000" {{ request('perPage') == '5000' ? 'selected' : '' }}>5000</option>
                            <option value="{{ $stores->total() }}"
                                {{ request('perPage') == $stores->total() ? 'selected' : '' }}>Semua</option>
                            <input type="hidden" name="status" value="{{ $status }}">
                        </select>
                    </form>

                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Tampilkan jumlah data yang ditampilkan -->
                            @if (!$stores->isEmpty())
                                <p class="d-inline-block">Showing {{ $stores->firstItem() }} to
                                    {{ $stores->lastItem() }} of
                                    {{ $stores->total() }} entries</p>
                            @endif
                        </div>

                        <!-- Daftar data yang akan diperbarui -->
                        {{-- <button id="load-updated-data" style="display: none;" class="btn btn-primary">
                            Load New Updated Data
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Category ID</th>
                        <th>Name Company</th>
                        {{-- <th>Phone</th> --}}
                        {{-- <th>Email</th> --}}
                        <th>Status</th>
                        <th>City</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        {{-- <th>Description</th> --}}
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stores as $store)
                        <tr>
                            <td>{{ number_format($i++, 0, '.', '.') }}</td>
                            <td>{{ $store['category']['name'] ?? '' }}</td>
                            {{-- <td>{{ $store->category->name }}</td> --}}

                            <td>{{ $store['name'] }}</td>
                            {{-- <td>{{ $store['phone'] }}</td> --}}
                            {{-- <td>{{ $store['email'] }}</td> --}}
                            <td>
                                <span class="badge {{ $store['status'] == 'ACTIVE' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $store['status'] }}
                                </span>
                            </td>

                            <td>{{ $store['city'] }}</td>
                            <td>{{ $store['latitude'] }}</td>
                            <td>{{ $store['longitude'] }}</td>
                            {{-- <td>{{ $store['description'] }}</td> --}}
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    @can('official-store-edit')
                                        <a href="{{ route('dashboard.official-store.edit', $store['id']) }}"
                                            class="text-warning ml-4" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can('official-store-delete')
                                        <a href="{{ route('dashboard.official-store.destroy', $store->id) }}"
                                            class="text-danger mx-5" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Hapus"
                                            onclick="event.preventDefault();
                                                     if (confirm('Anda yakin ingin menghapus?')) {
                                                         document.getElementById('delete-form-{{ $store->id }}').submit();
                                                     }">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                        <form id="delete-form-{{ $store->id }}"
                                            action="{{ route('dashboard.official-store.destroy', $store->id) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <th>#</th>
                    <th>Category ID</th>
                    <th>Name Company</th>
                    {{-- <th>Phone</th> --}}
                    {{-- <th>Email</th> --}}
                    <th>Status</th>
                    <th>City</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    {{-- <th>Description</th> --}}
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>



    @if ($stores->total() > $stores->perPage())
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item {{ $stores->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link"
                        href="{{ $stores->appends(['status' => $status, 'perPage' => Request::get('perPage')])->url(1) }}"
                        aria-label="First">
                        <span aria-hidden="true">First</span>
                    </a>
                </li>
                {{ $stores->appends(['status' => $status, 'perPage' => Request::get('perPage')])->links() }}
                <li class="page-item {{ $stores->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link"
                        href="{{ $stores->appends(['status' => $status, 'perPage' => Request::get('perPage')])->url($stores->lastPage()) }}"
                        aria-label="Last">
                        <span aria-hidden="true">Last</span>
                    </a>
                </li>
            </ul>
        </nav>
    @endif

    <link rel='stylesheet' href='https://unpkg.com/leaflet@1.8.0/dist/leaflet.css' crossorigin='' />
    <!-- Include Leaflet Routing Machine CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.css">

    <script src='https://unpkg.com/leaflet@1.8.0/dist/leaflet.js' crossorigin=''></script>
    <script src='https://unpkg.com/leaflet-control-geocoder@2.4.0/dist/Control.Geocoder.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-routing-machine/3.2.12/leaflet-routing-machine.min.js">
    </script>

    <script src="https://unpkg.com/leaflet-routing-machine@3.3.0/dist/leaflet-routing-machine.js"></script>

    <!-- Include Leaflet Numbered Markers CSS and JS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/leaflet-numbered-markers/0.1/leaflet-numbered-markers.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-numbered-markers/0.1/leaflet-numbered-markers.js"></script>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

    <!-- Include leaflet-search CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-search/dist/leaflet.control.search.min.css" />
    <script src="https://unpkg.com/leaflet-control-search/dist/leaflet.control.search.min.js"></script>


    <br>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Leaflet</h4>
            <div id='map'></div>
        </div>
    </div>


    @push('style')
        <style>
            #map {
                width: '100%';
                height: 400px;
            }
        </style>


        <style>
            /* Mengatur responsivitas pagination */
            .pagination {
                display: flex;
                justify-content: center;
                /* align-items: center; */
                /* margin-top: 20px; */
            }

            /* Mengatur tampilan pagination di perangkat dengan lebar kecil */
            @media (max-width: 768px) {
                .pagination {
                    flex-direction: column;
                }

                .pagination ul {
                    margin-top: 10px;
                }
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('select option[value=""]').hide();
            });
        </script>
        {{-- <script>
            const loadUpdatedDataButton = document.getElementById('load-updated-data');

            function checkForUpdates() {
                fetch("{{ route('dashboard.official-store.loadNewData') }}")
                    .then(response => response.json())
                    .then(data => {
                        const newDataCount = data.newDataCount;

                        // Tampilkan jumlah data baru dalam tombol
                        loadUpdatedDataButton.textContent = `Load Updated Data (${newDataCount} new)`;

                        // Jika ada data baru, tampilkan tombol
                        if (newDataCount > 0) {
                            loadUpdatedDataButton.style.display = 'block';
                        } else {
                            loadUpdatedDataButton.style.display = 'none';
                        }

                        // Fungsi untuk mereload halaman saat tombol diklik
                        loadUpdatedDataButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            location.reload(); // Fungsi ini akan mereload halaman.
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Polling data setiap 5 detik
            setInterval(checkForUpdates, 5000);

            // Panggil checkForUpdates() pertama kali saat halaman dimuat
            checkForUpdates();
        </script> --}}
    @endpush

    {{-- <script>
        let map, markers = [];

        function initMap() {
            map = L.map('map', {
                center: {
                    lat: 28.626137,
                    lng: 79.821603,
                },
                zoom: 15
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            map.on('click', mapClicked);
            initMarkers();
        }
        initMap();

        function initMarkers() {
            const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

            let sortedMarkers = [...initialMarkers];
            sortedMarkers.sort((a, b) => {
                const distanceA = Math.sqrt(Math.pow(28.626137 - a.position.lat, 2) + Math.pow(79.821603 - a
                    .position.lng, 2));
                const distanceB = Math.sqrt(Math.pow(28.626137 - b.position.lat, 2) + Math.pow(79.821603 - b
                    .position.lng, 2));
                return distanceA - distanceB;
            });

            for (let index = 0; index < sortedMarkers.length; index++) {
                const data = sortedMarkers[index];
                data.position.name = `Toko ${index + 1}`;

                const statusBadge = data.position.status === 'ACTIVE' ? 'success' : 'danger';

                const popupContent = `
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="mb-2">
                            <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Latitude:</strong> ${data.position.lat}</p>
                            <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Longitude:</strong> ${data.position.lng}</p>
                            <p><i class="bi bi-shop text-success"></i> <strong class="text-success">Official Store:</strong> ${data.position.name}</p>
                            <p>
                                <i class="bi bi-tags-fill text-success"></i>
                                <strong class="text-success">Status:</strong>
                                <span class="badge bg-${statusBadge} rounded-pill">${data.position.status}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-2">
                            <p><i class="bi bi-building text-success"></i> <strong class="text-success">City:</strong> ${data.position.city}</p>
                            <p><i class="bi bi-map-fill text-success"></i> <strong class="text-success">Province:</strong> ${data.position.province}</p>
                            <p><i class="bi bi-signpost-fill text-success"></i> <strong class="text-success">Address:</strong> ${data.position.address}</p>
                            <p><i class="bi bi-bookmark-fill text-success"></i> <strong class="text-success">Postal Code:</strong> ${data.position.postal_code}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;



                marker.addTo(map).bindPopup(popupContent);
                map.panTo(data.position);
                markers.push(marker);
            }
        }



        function mapClicked($event) {
            console.log(map);
            console.log($event.latlng.lat, $event.latlng.lng);
        }

        function markerClicked($event, index) {
            console.log(map);
            console.log($event.latlng.lat, $event.latlng.lng);
        }

        function markerDragEnd($event, index) {
            console.log(map);
            console.log($event.target.getLatLng());
        }
    </script> --}}


    <script>
        let map, markers = [];
        let storeData = <?php echo json_encode($initialMarkers); ?>;

        map = L.map('map', {
            center: {
                lat: 28.626137,
                lng: 79.821603,
            },
            zoom: 15
        });

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLat = position.coords.latitude;
                    const userLng = position.coords.longitude;

                    const userMarker = L.marker([userLat, userLng], {
                        icon: L.divIcon({
                            className: 'custom-icon',
                            html: `<i class="bi bi-person-fill" style="color: blue; font-size:24px;"></i>`,
                            iconSize: [30, 30]
                        })
                    }).addTo(map);

                    const popupContent = `
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <div class="mb-2">
                                    <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Latitude:</strong> ${userLat}</p>
                                    <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Longitude:</strong> ${userLng}</p>
                                    <p><i class="bi bi-person-fill text-success"></i> <strong class="text-success">Your Location</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                    userMarker.bindPopup(popupContent).openPopup();

                    map.panTo([userLat, userLng]);

                    const distances = [];
                    for (let i = 0; i < storeData.length; i++) {
                        const data = storeData[i];
                        const storeLat = data.position.lat;
                        const storeLng = data.position.lng;
                        const distance = calculateDistance(userLat, userLng, storeLat, storeLng);
                        distances.push({
                            index: i,
                            distance: distance
                        });
                    }

                    distances.sort((a, b) => a.distance - b.distance);

                    for (let i = 0; i < distances.length; i++) {
                        const index = distances[i].index;
                        const order = i + 1;
                        storeData[index].order = order;
                    }

                    initMarkers();

                    const closestStore = storeData[distances[0].index];
                    const closestStoreLat = closestStore.position.lat;
                    const closestStoreLng = closestStore.position.lng;

                    const userToClosestStorePolyline = L.polyline([
                        [userLat, userLng],
                        [closestStoreLat, closestStoreLng]
                    ], {
                        color: 'blue'
                    }).addTo(map);

                    for (let i = 0; i < distances.length - 1; i++) {
                        const currentStore = storeData[distances[i].index];
                        const nextStore = storeData[distances[i + 1].index];
                        const currentStoreLat = currentStore.position.lat;
                        const currentStoreLng = currentStore.position.lng;
                        const nextStoreLat = nextStore.position.lat;
                        const nextStoreLng = nextStore.position.lng;

                        const storeToNextStorePolyline = L.polyline([
                            [currentStoreLat, currentStoreLng],
                            [nextStoreLat, nextStoreLng]
                        ], {
                            color: 'blue'
                        }).addTo(map);
                    }
                },
                (error) => {
                    console.error(error);
                }
            );
        } else {
            console.log("Geolocation tidak didukung oleh browser ini.");
        }

        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius bumi dalam km
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c; // Jarak dalam km
            return distance;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        function initMarkers() {
            for (let index = 0; index < storeData.length; index++) {
                const data = storeData[index];
                const statusBadge = data.position.status === 'ACTIVE' ? 'success' : 'danger';
                const statusBadge2 = data.position.status === 'ACTIVE' ? 'green' : 'red';

                const marker = L.marker(data.position, {
                    icon: L.divIcon({
                        className: 'custom-icon',
                        html: `
                    <i class="bi bi-geo-alt-fill" style="color: ${statusBadge2}; font-size:24px;"></i>
                    <strong class="text-center">Toko ${data.order}</strong>
                    `,
                        iconSize: [30, 30]
                    })
                });

                const popupContent = `
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="mb-2">
                                <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Latitude:</strong> ${data.position.lat}</p>
                                <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Longitude:</strong> ${data.position.lng}</p>
                                <p><i class="bi bi-shop text-success"></i> <strong class="text-success">Official Store:</strong> ${data.position.name}</p>
                                <p>
                                    <i class="bi bi-tags-fill text-success"></i>
                                    <strong class="text-success">Status:</strong>
                                    <span class="badge bg-${statusBadge} rounded-pill">${data.position.status}</span>
                                </p>
                                <p><strong class="text-success">Order:</strong> ${data.order}</p>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-2">
                                <p><i class="bi bi-building text-success"></i> <strong class="text-success">City:</strong> ${data.position.city}</p>
                                <p><i class="bi bi-map-fill text-success"></i> <strong class="text-success">Province:</strong> ${data.position.province}</p>
                                <p><i class="bi bi-signpost-fill text-success"></i> <strong class="text-success">Address:</strong> ${data.position.address}</p>
                                <p><i class="bi bi-bookmark-fill text-success"></i> <strong class="text-success">Postal Code:</strong> ${data.position.postal_code}</p>
                            </div>
                        </div>
                    </div>
                </div>
            `;

                marker.addTo(map).bindPopup(popupContent);
                map.panTo(data.position);
                markers.push(marker);
            }
        }

        initMap();

        // function initMarkers() {
        //     const initialMarkers = <?php echo json_encode($initialMarkers); ?>;

        //     for (let index = 0; index < initialMarkers.length; index++) {
        //         const data = initialMarkers[index];
        //         const statusBadge = data.position.status === 'ACTIVE' ? 'success' : 'danger';
        //         const statusBadge2 = data.position.status === 'ACTIVE' ? 'green' : 'red';

        //         const marker = L.marker(data.position, {
        //             icon: L.divIcon({
        //                 className: 'custom-icon',
        //                 html: `<i class="bi bi-geo-alt-fill" style="color: ${statusBadge2}; font-size:24px;"></i>`,
        //                 iconSize: [30, 30]
        //             })
        //         });

        //         const popupContent = `
    //             <div class="container">
    //                 <div class="row">
    //                     <div class="col">
    //                         <div class="mb-2">
    //                             <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Latitude:</strong> ${data.position.lat}</p>
    //                             <p><i class="bi bi-geo-alt-fill text-success"></i> <strong class="text-success">Longitude:</strong> ${data.position.lng}</p>
    //                             <p><i class="bi bi-shop text-success"></i> <strong class="text-success">Official Store:</strong> ${data.position.name}</p>
    //                             <p>
    //                                 <i class="bi bi-tags-fill text-success"></i>
    //                                 <strong class="text-success">Status:</strong>
    //                                 <span class="badge bg-${statusBadge} rounded-pill">${data.position.status}</span>
    //                             </p>
    //                         </div>
    //                     </div>
    //                     <div class="col">
    //                         <div class="mb-2">
    //                             <p><i class="bi bi-building text-success"></i> <strong class="text-success">City:</strong> ${data.position.city}</p>
    //                             <p><i class="bi bi-map-fill text-success"></i> <strong class="text-success">Province:</strong> ${data.position.province}</p>
    //                             <p><i class="bi bi-signpost-fill text-success"></i> <strong class="text-success">Address:</strong> ${data.position.address}</p>
    //                             <p><i class="bi bi-bookmark-fill text-success"></i> <strong class="text-success">Postal Code:</strong> ${data.position.postal_code}</p>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>
    //         `;

        //         marker.addTo(map).bindPopup(popupContent);
        //         map.panTo(data.position);
        //         markers.push(marker);
        //     }
        // }

        function generateMarker(data, index) {
            return L.marker(data.position, {
                    draggable: data.draggable
                })
                .on('click', (event) => markerClicked(event, index))
                .on('dragend', (event) => markerDragEnd(event, index));
        }

        function mapClicked($event) {
            console.log(map);
            console.log($event.latlng.lat, $event.latlng.lng);
        }

        function markerClicked($event, index) {
            console.log(map);
            console.log($event.latlng.lat, $event.latlng.lng);
        }

        function markerDragEnd($event, index) {
            console.log(map);
            console.log($event.target.getLatLng());
        }
    </script>




@endsection
