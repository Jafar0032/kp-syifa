<x-inti-layout :title="'Detail Layanan'">

    <div class="container">

        <a href="https://wa.me/628117830717" class="wa-float pt-2" target="_blank">
            <div><i class="fa fa-xl fa-whatsapp my-float"></i> <span><strong> &nbsp; Hubungi Kami</strong></span></div>
        </a>

        <div class="py-12">
            <div class="py-12">
                <div class="pt-5">
                    <a href="{{ url('/home') }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
                    <h6 class="d-inline montserrat-extra text-start">{{ $layanan->nama_layanan }}</h6>
                    <h6 class="mt-5 montserrat-med text-start color-abu-muda">{{ $layanan->deskripsi }}</h6>
                    <h6 class="my-4 mt-5 montserrat-extra text-start">Info Harga Layanan</h6>

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
                    <a type="button" href="{{ url('/pesan/'.$layanan->id) }}" class="btn btn-primary mt-4 py-2 px-3" id="pesan-btn">Pesan</a>
                </div>
            </div>
        </div>

    </div>

</x-inti-layout>

<link rel="stylesheet" href="{{ asset('css/floatingWA.css') }}">