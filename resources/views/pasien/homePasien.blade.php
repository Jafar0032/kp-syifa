<x-inti-layout :title="'Home'">

    <div class="container">

        <a href="https://wa.me/628117830717" class="wa-float pt-2" target="_blank">
            <div><i class="fa fa-xl fa-whatsapp my-float"></i> <span><strong> &nbsp; Hubungi Kami</strong></span></div>
        </a>

        <!-- Header -->
        <div class="pt-5 pb-4">
            <div class="py-md-5">
                <div class="pt-5">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <h6 class="montserrat-extra text-start mt-5 header-text">Home Care<br> Klinik Al-Syifa Palembang</h6>
                            <p class="color-abu-muda montserrat-med mt-3 fw-normal" style="font-size: 15px;">
                                Menyediakan berbagai layanan home care seperti perawatan luka, pemasangan infus, dan masih banyak lagi.
                                <br>
                                Kami siap melayani anda dengan sangat baik
                            </p>
                            <div class="color-abu-muda montserrat-med mt-3 fw-normal">Buka : <span class="montserrat-extra color-abu ms-2">08.00 - 18.30</span></div>
                        </div>
                        <div class="col-lg-6 col-md-6 py-5">
                            <img src="{{ asset('image/Logo_Kliniks.png') }}" class="image ms-auto me-auto d-none d-none d-md-block" alt="Logo klinik" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan -->
        <div class="pb-3 d-md-flex align-items-center">
            <h6 class="montserrat-extra content-sub mt-5 me-auto"><strong>LAYANAN</strong></h6>
            <div class="ms-auto mt-4 mt-md-5 pb-md-4">
                <div class="input-group rounded">
                    <input type="text" class="form-control rounded" id="search" name="search" placeholder="Cari layanan . . ." aria-label="Search" aria-describedby="search-addon" />
                    <span class="input-group-text bg-inti text-white border-0" id="search-addon">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="row my-4 alldata">
            @foreach($layanan as $key => $item)
            <div class="col-lg-3 col-md-4 col-sm-12 col-12 mb-5">
                <div class="p-3 card border-end-0 border-start-0 border-bottom-0 bg-inti-muda" id="" style="height: 14rem;">
                    <a href="{{ url('/layanan/'.$item->id) }}" class="remove-underline">
                        <h6 class="montserrat-extra text-center mt-2 color-abu text-uppercase">{{ $item->nama_layanan }}</h6>
                        <div class="card-body">
                            <p class="card-text montserrat-med text-start color-abu-muda mt-2 teks" id="deskripsi">{{ $item->deskripsi }}</p>
                        </div>
                    </a>
                    <a type="button" href="{{ url('/layanan/'.$item->id) }}" class="btn btn-primary my-1 mt-auto ms-auto me-auto py-2 px-3" id="pesan-btn">Lihat</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="row my-4" id="search_list">

        </div>

    </div>

</x-inti-layout>

<link rel="stylesheet" href="{{ asset('css/search.css') }}">
<link rel="stylesheet" href="{{ asset('css/floatingWA.css') }}">

<script>
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var query = $(this).val();
            if (query != "") {
                $('.alldata').hide();
                $('#search_list').show();
                $.ajax({
                    url: "home/search",
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        $('#search_list').html(data);
                    }
                });
            } else {
                $('.alldata').show();
                $('#search_list').hide();
            }
        });
    });
</script>