<x-admin-layout :title="'Update Pesanan'">

    <div class="container">
        <div class="py-5">
            <!-- Header -->
            <a href="{{ url('detailPesanan/' .$pesanan->id) }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
            <h3 class="montserrat-extra text-start text-shadow pt-4 d-inline">Edit Pesanan</h3>

            <div class="mt-4">
                @if($errors->any())
                {!! implode('', $errors->all('
                <div class="text-danger ms-3 mt-2 montserrat-extra"><i class="fa-2xs fa-sharp fa-solid fa-circle"></i> &nbsp; :message </div>
                ')) !!}
                @endif
            </div>

            <form action="{{ url('pesan/update/'.$pesanan->id) }}" method="post" enctype="multipart/form-data">
                @method("PATCH")
                @csrf

                <div class="row mt-5">
                    <div class="col-lg-7 col-md-12 shadow-tipis rounded-card py-4 px-4 mx-3">
                        <div class="d-flex">

                            <div class="form-group justify-content-start d-inline">
                                <label for="layanan" class="my-2 color-inti montserrat-extra" style="font-size: smaller;">Layanan</label>
                                <select class="form-control select2 " name="layanan" id="layanan" style="max-width: max-content; padding-right: 37px;">
                                    <option disabled value>Pilih Layanan</option>

                                    @foreach($layanan as $item)

                                    <option value="{{ $item->id }}" @if ($item->id == $pesanan->id_layanan)
                                        selected="selected"
                                        @endif
                                        > {{ $item->nama_layanan }}
                                    </option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group d-inline justify-content-end ms-auto">
                                <label for="id_status_pesanan" class="my-2 color-inti montserrat-extra" style="font-size: smaller;">Status Pesanan</label>

                                <select class="form-control select2" name="id_status_pesanan" id="id_status_pesanan">
                                    <option disabled value>Pilih Status Pesanan</option>

                                    @foreach($statusPesanan as $item)

                                    <option value="{{ $item->id }}" @if ($item->id == $pesanan->id_status_pesanan)
                                        selected="selected"
                                        @endif
                                        > {{ $item->status }}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                <div class="montserrat-bold mt-3" style="font-size: 15px;">Tanggal Perawatan</div>
                                <div class="montserrat-bold mt-4" style="font-size: 15px;">Jam Perawatan</div>
                                <div class="montserrat-bold mt-4" style="font-size: 15px;">Keluhan</div>
                                <div class="montserrat-bold mt-4" style="font-size: 15px;">Alamat</div>
                            </div>
                            <div class="col-lg-9 col-md-6 col-sm-6 col-6">

                                <!-- Tanggal Perawatan -->
                                <div class="form-group">
                                    <input style="max-width: fit-content;" type="date" name="tanggal_perawatan" id="tanggal_perawatan" placeholder="Masukkan tanggal_perawatan" class="form-control my-2" value="{{ old('tanggal_perawatan') ?? $pesanan->tanggal_perawatan }}">
                                </div>

                                <!-- Jam Perawatan -->
                                <div class="form-group">
                                    <input style="max-width: fit-content;" type="time" name="jam_perawatan" id="jam_perawatan" placeholder="Masukkan jam_perawatan" class="form-control my-2" value="{{ old('jam_perawatan') ?? $pesanan->jam_perawatan }}">
                                </div>

                                <!-- Keluhan -->
                                <div class="form-group">
                                    <input type="text" name="keluhan" id="keluhan" placeholder="Masukkan keluhan" class="form-control my-2" value="{{ old('keluhan') ?? $pesanan->keluhan }}">
                                </div>

                                <!-- Alamat -->
                                <div class="form-group">
                                    <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat" class="form-control my-2" value="{{ old('alamat') ?? $pesanan->alamat }}">
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 col-12">
                        <!-- Data Pasien -->
                        <div class="shadow-tipis rounded-card pt-3 pb-1 px-3 mx-2" style="height: 11.2rem;">
                            <div class="d-flex">
                                <div class="montserrat-extra text-start color-inti" style="font-size: larger;">Data Pasien</div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6">
                                    <div class="montserrat-bold mt-2">NIK</div>
                                    <div class="montserrat-bold mt-4">Nama</div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-6 col-6">
                                    <div class="form-group">
                                        <input disabled type="text" class="form-control" value="{{ $pesanan->user_pasien->NIK }}" style="max-width: max-content;">
                                    </div>
                                    <div class="form-group mt-3">
                                        <input disabled type="text" class="form-control" value="{{ $pesanan->user_pasien->nama }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Data Tenaga Medis -->
                        <div class="shadow-tipis rounded-card py-3 px-3 mx-2 mt-4" style="height: 12rem;">
                            <div class="d-flex">
                                <div class="montserrat-extra text-start color-inti" style="font-size: larger;">Data Medis</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-4">
                                    <div class="montserrat-bold mt-1">Status</div>
                                    <div class="montserrat-bold mt-4">Nama</div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-sm-6 col-6 mt-4">
                                    <div class="form-group">
                                        <select class="form-control select2" name="status_jasa" id="status_jasa" style="max-width: max-content; padding-right: 37px;">
                                            @foreach($statusJasa as $item)
                                            @if($item->status_user->is_active == 'Y')
                                            <option value="{{ $item->id_status_jasa }}" @if ($item->id_status_jasa == $pesanan->id_status_jasa)
                                                selected="selected"
                                                @endif
                                                > {{ $item->status_user->status }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mt-2">
                                        <select class="form-control select2" name="id_jasa" id="id_jasa" style="max-width: fit-content; padding-right: 35px;">
                                            <option value="" hidden>Pilih staff medis</option>
                                            @foreach($nikJasa as $item)
                                            <option value="{{ $item->id }}" @if ($item->id == $pesanan->id_jasa)
                                                selected="selected"
                                                @endif
                                                > {{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($pesanan->foto)
                <div class="float-group">
                    <div class="my-2">
                        <img src="{{ asset('public/public/foto_pesanan/'.$pesanan->foto) }}" alt="Foto Luka Pasien" width="100">
                    </div>
                </div>
                <div class="form-group">
                    <label class="my-2" for="foto">Foto Luka Pasien</label>
                    <input type="file" accept="image/*" name="foto" id="foto" class="form-control my-2" >
                    @error('foto')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @endif

                @if($pesanan->bukti_pembayaran == null)
                <div class="form-group">

                    <label class="my-2" for="bukti_pembayaran">Bukti pembayaran</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control my-2" accept="image/*" >
                </div>
                @else
                <div class="float-group">
                    <label class="my-2" for="status_pembayaran">Bukti pembayaran</label>
                    <div class="my-2">
                        <img src="{{asset('public/public/bukti_pembayaran/'.$pesanan->bukti_pembayaran)}}" alt="" width="100">
                    </div>
                </div>
                <div class="form-group">

                    <label class="my-2" for="bukti_pembayaran">Bukti pembayaran</label>
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control my-2">
                </div>
                @endif


                <button type="submit" class="btn btn-success mt-4 ms-2" id="pesan-btn">Update</button>
            </form>

        </div>
    </div>
</x-admin-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#layanan').on('change', function() {
            var layananID = $(this).val();
            if (layananID) {
                $.ajax({
                    url: '/getJasa/' + layananID,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#status_jasa').empty();
                            $('#status_jasa').append('<option value="" hidden>Pilih jasa</option>');
                            $('#id_jasa').empty();
                            $('#id_jasa').append('<option value="" hidden>Pilih staff medis</option>');
                            $.each(data, function(key, status_jasa) {
                                $('select[name="status_jasa"]').append('<option value="' + status_jasa.id_status_jasa + '">' + status_jasa.status_user.status + '</option>');
                            });
                        } else {
                            $('#status_jasa').empty();
                        }
                    }
                });
            } else {
                $('#status_jasa').empty();
            }
        });
    });

    $(document).ready(function() {
        $('#status_jasa').on('change', function() {
            var status_jasaID = $(this).val();
            console.log(status_jasaID);
            if (status_jasaID) {
                $.ajax({
                    url: '/getNik/' + status_jasaID,
                    type: 'GET',
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('#id_jasa').empty();
                            $('#id_jasa').append('<option value="" hidden>Pilih staff medis</option>');
                            $.each(data, function(key, nik_jasa) {
                                $('select[name="id_jasa"]').append('<option value="' + nik_jasa.id + '">' + nik_jasa.NIK + ' ; ' + nik_jasa.nama + '</option>');
                            });
                        } else {
                            $('#id_jasa').empty();
                        }
                    }
                });
            } else {
                $('#id_jasa').empty();
            }
        });
    });
</script>