<x-admin-layout :title="'Detail Layanan'">

    <div class="container">
        <div class="py-5">

            <div class="d-flex">
                <div class="d-inline mt-4 mb-3">
                    <!-- Header -->
                    <a href="{{ url('/daftarLayanan') }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
                    <h3 class="montserrat-extra text-start text-shadow pt-4 d-inline">Detail Layanan</h3>
                </div>
                <div class="ms-auto mt-auto justify-content-end d-inline ps-5" style="overflow: hidden;">
                    @if (session()->has('info'))
                    <div class="custom-alert align-items-end">
                        <div class="row">
                            <div class="col-2">
                                <span class="fas fa-exclamation-circle"></span>
                            </div>
                            <div class="col-8">
                                <span class="msg">{{ session()->get('info') }}</span>
                            </div>
                            <div class="col-2">
                                <div class="close-btn">
                                    <span class="fas fa-times"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-lg-12">
                    <div class="shadow-tipis rounded-card pt-3 pb-4 px-3 mx-2">
                        <div class="d-flex">
                            <div class="montserrat-extra text-start color-inti" style="font-size: larger;">Data Layanan</div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-2">
                                <div class="montserrat-bold">Nama Layanan</div>
                                <div class="montserrat-bold mt-2">Deskripsi</div>
                                <div class="montserrat-bold mt-2">Pakai Foto</div>
                                <div class="montserrat-bold mt-2">Tampilkan</div>
                            </div>
                            <div class="col-lg-10">
                                <div class="montserrat-extra">: &nbsp; {{ $layanan->nama_layanan }}</div>
                                <div class="montserrat-extra mt-2">: &nbsp; {{ $layanan->deskripsi }}</div>
                                <!-- Pakai Foto Layanan -->
                                @if($layanan->use_foto == 'Y')
                                <div class="mt-2" style="color: #07DA63;"><span class="montserrat-extra color-abu">: &nbsp; </span><i class="fa-regular fa-circle-check fa-xl"></i></div>
                                @else
                                <div class="text-danger mt-2"><span class="montserrat-extra color-abu">: &nbsp; </span><i class="fa-regular fa-circle-xmark fa-xl"></i></div>
                                @endif

                                <!-- Tampilkan Layanan -->
                                @if($layanan->show == 'Y')
                                <div class="mt-2" style="color: #07DA63;"><span class="montserrat-extra color-abu">: &nbsp; </span><i class="fa-regular fa-circle-check fa-xl"></i></div>
                                @else
                                <div class="text-danger mt-2"><span class="montserrat-extra color-abu">: &nbsp; </span><i class="fa-regular fa-circle-xmark fa-xl"></i></div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-4 px-2">
                            @if($harga_layanan != null)
                            <table class="table table-borderless table-sm">
                                <thead>
                                    <tr class="d-flex mt-3">
                                        <th scope="col" class="col-md-2 col-sm-6 col-6">Tenaga Medis</th>
                                        <th scope="col" class="col-md-2 col-sm-6 col-6">Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($harga_layanan as $item)
                                    <tr class="d-flex mt-2">
                                        <td scope="row" class="col-md-2 col-sm-6 col-6">{{ $item->status_user->status }}</td>
                                        <td class="col-md-2 col-sm-6 col-6">Rp @currency($item->harga)</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ url('/daftarLayanan/updateView/'.$layanan->id) }}" class="btn btn-success mt-4 ms-3" id="btn-edit-kecil">Edit</a>

        </div>
    </div>

</x-admin-layout>

<script>
    $(document).ready(function() {
        $('.custom-alert').addClass("show");
        $('.custom-alert').removeClass("hide");
        $('.custom-alert').addClass("showAlert");
        setTimeout(function() {
            $('.custom-alert').removeClass("show");
            $('.custom-alert').addClass("hide");
        }, 5000);
    });
    $('.close-btn').click(function() {
        $('.custom-alert').removeClass("show");
        $('.custom-alert').addClass("hide");
    });
</script>