<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/themes/dark.css">

<x-inti-layout :title="'Buat Pesanan'">

    <div class="container">

        <a href="https://wa.me/628117830717" class="wa-float pt-2" target="_blank">
            <div><i class="fa fa-xl fa-whatsapp my-float"></i> <span><strong> &nbsp; Hubungi Kami</strong></span></div>
        </a>

        <div class="pt-5">
            <div class="pt-5">
                <div class="mt-5">
                    <a href="{{ url('/layanan/'.$layanan->id) }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
                    <h6 class="d-inline montserrat-extra text-start">{{ $layanan->nama_layanan }}</h6>
                </div>

                <div class="mt-4">
                    @if($errors->any())
                    {!! implode('', $errors->all('
                    <div class="text-danger ms-3 mt-2 montserrat-extra"><i class="fa-2xs fa-sharp fa-solid fa-circle"></i> &nbsp; :message </div>
                    ')) !!}
                    @endif
                </div>

                <form action="{{ url('pesan/'.$layanan->id) }}" method="post" enctype="multipart/form-data" class="mt-4" id="formTambahPesanan">
                    @csrf

                    <div class="form-group mt-3">
                        <label for="alamat">Alamat</label>
                        @if(!empty($alamat[0]))
                        <select class="form-control select2 my-2" name="alamat" id="alamat">
                            <option disabled value>Pilih alamat</option>
                            @foreach($alamat as $item)
                            <option value="{{ $item->id }}"> {{ $item->alamat }}</option>
                            @endforeach
                        </select>
                        @else
                        <div class="mt-3">
                            <div class="montserrat-extra text-danger font-smaller">Belum ada alamat yang terdaftar, silahkan Tambah Alamat</div>
                            <a href="{{ url('/profile/alamat/addView') }}" class="btn btn-primary me-5 mt-2" id="pesan-btn-sedang">
                                <i class="fa-solid fa-plus fa-lg me-3"></i>Tambah Alamat
                            </a>
                            @endif
                        </div>
                    </div>

                    @if(!empty($alamat[0]))
                    <div class="montserrat-extra text-start color-inti">
                        <span class="font-smaller">Jarak ke Klinik (meter) : </span>
                        <input type="text" name="jarak" id="jarak" class="font-smaller ps-2 pe-0" size="8" style="border: none; font-weight: bolder;" value="{{ $alamat[0]->jarak }}" readonly>
                    </div>
                    @endif

                    <div class="form-group mt-4">
                        <label for="keluhan">Keluhan Penyakit <span class="color-abu-tuo">(Jika ada)</span></label>
                        <input type="text" name="keluhan" id="keluhan" placeholder="Contoh: Perih dibagian luka" class="form-control my-2" value="{{ old('keluhan') }}">
                    </div>

                    <div class="form-group mt-4">
                        <label for="tanggal_perawatan">Tanggal Perawatan <span class="font-smaller color-abu-tuo">(Minggu libur)</span></label>
                        <input name="tanggal_perawatan" id="tanggal_perawatan" placeholder="Silahkan pilih Tanggal Perawatan " class="form-control my-2" value="{{ old('tanggal_perawatan') }}">
                    </div>

                    <div class="form-group mt-4">
                        <label for="jam_perawatan">Jam Perawatan <span class="font-smaller color-abu-tuo">(08:00 - 18:30)</span></label>
                        <div id="info_tanggal_perawatan" class="montserrat-extra text-danger mt-1" style="font-size: 11px;">Silahkan isi tanggal perawatan dulu</div>
                        <input name="jam_perawatan" id="jam_perawatan" placeholder="Silahkan pilih Jam Perawatan" class="form-control my-2" value="{{ old('jam_perawatan') }}" required>
                    </div>

                    @if($layanan->use_foto == 'Y')
                    <div class="form-group mt-1">
                        <label for="foto">Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control my-2" accept="image/*">
                    </div>
                    @endif

                    <div class="form-group mt-4">
                        <label for="id_status_jasa">Jasa Tenaga Medis</label>
                        <select class="form-select select2 my-2" name="id_status_jasa" id="id_status_jasa">
                            <option disabled value>Pilih jasa</option>
                            @foreach($jasa as $item)
                            @if($item->status_user->status !== "Pasien" && $item->status_user->status !== "Admin" && $item->status_user->is_active !== "T")
                            <option value="{{ $item->id_status_jasa }}|{{ $item->status_user->status }}|{{ $item->harga }}"> {{ $item->status_user->status }} -- Rp @currency($item->harga)</option>
                            @endif

                            @endforeach
                        </select>
                    </div>

                    <input hidden type="text" id="harga_status_jasa" class="form-control my-2" value="Rp @currency($item->harga)">

                    <button type="button" class="btn btn-success mt-3" id="pesan-btn" data-bs-toggle="modal" data-bs-target="#modalKonfirmasiPesananPasien">Pesan</button>
                </form>

                <!-- Modal Konfirmasi Pesanan Pasien -->
                <div class="modal fade" id="modalKonfirmasiPesananPasien" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content shadow-tipis">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center">
                                    <i class="fa-regular fa-file-lines nav_icon" style="color: #3E82E4; font-size: 70px;"></i>
                                </div>
                                <div class="text-center montserrat-extra mt-4" style="font-size: larger;">Konfirmasi Pesanan</div>
                                <table class="table table-borderless mt-4">
                                    <tbody>
                                        <tr class="montserrat-extra font-smaller">
                                            <td class="text-start">Layanan</td>
                                            <td class="color-abu text-end">{{ $layanan->nama_layanan }}</td>
                                        </tr>
                                        <tr class="montserrat-bold font-smaller">
                                            <td>Tanggal</td>
                                            <td class="color-abu text-end" id="tanggalModal"></td>
                                        </tr>
                                        <tr class="montserrat-bold font-smaller">
                                            <td>Jam</td>
                                            <td class="color-abu text-end" id="jamModal"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="montserrat-extra font-smaller">
                                            <td class="text-start">Tenaga Medis</td>
                                            <td class="color-abu text-end" id="tenagaMedisModal"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <hr>
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr class="montserrat-bold font-smaller">
                                            <td class="text-start">Harga</td>
                                            <td class="color-abu text-end" id="hargaModal"></td>
                                        </tr>
                                        <tr class="montserrat-bold font-smaller">
                                            <td class="text-start">Ongkos</td>
                                            <td class="color-abu text-end" id="ongkosModal"></td>
                                        </tr>
                                        <tr class="montserrat-extra">
                                            <td class="text-start">Total</td>
                                            <td class="color-abu text-end" id="totalModal"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-4 mb-4">
                                <div class="col-6 text-center">
                                    <!-- Buttton Cancel -->
                                    <button type="button" class="btn btn-secondary px-md-4 py-md-2 px-3 py-2" id="btn-cancel-sedang-pasien" data-bs-dismiss="modal">Cancel</button>
                                </div>
                                <div class="col-6 text-center">
                                    <!-- Button Konfirmasi Pesanan -->
                                    <button type="submit" form="formTambahPesanan" class="btn btn-primary px-md-4 py-md-2 px-3 py-2" id="btn-konfirmasi-sedang-pasien">Konfirmasi</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    </div>

</x-inti-layout>
<link rel="stylesheet" href="{{ asset('css/floatingWA.css') }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script>
    $(document).ready(function() {
        $('#alamat').on('change', function() {
            let jarakID = $(this).val();
            $.ajax({
                url: '/getJarak/' + jarakID,
                type: 'GET',
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                dataType: "json",
                success: function(data) {
                    if(data){
                        $('#jarak').val(data.jarak[0].jarak);
                    }
                    else{
                        $('#jarak').val("");
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    $("#tanggal_perawatan").flatpickr({
        dateFormat: "Y-m-d",
        minDate: "today",
        "disable": [
            function(date) {
                return (date.getDay() === 0); // disable hari minggu
            }
        ],
        locale: "id"
    });

    const picker = flatpickr("#jam_perawatan", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        minTime: "08:00",
        maxTime: "18:30",
        readOnly: false,
        disableMobile: "true",
        locale: "id"
    });

    picker.input.disabled = true;

    let currentDate = new Date();
    // Kalau tanggal kurang dari 10, tambai angka 0 didepan
    let currentTanggal = currentDate.getDate() < 10 ? "0" + currentDate.getDate() : currentDate.getDate();
    // Kalau bulan kurang dari 10, tambai angka 0 didepan
    let currentMonth = currentDate.getMonth() + 1 < 10 ? "0" + (currentDate.getMonth() + 1) : currentDate.getMonth() + 1;
    let currentYear = currentDate.getFullYear();
    let currentHours = currentDate.getHours();
    let currentMinutes = currentDate.getMinutes();

    let tanggal_hari_ini = `${currentYear}-${currentMonth}-${currentTanggal}`
    
    $(document).on('change', '#tanggal_perawatan', function() {
        
        let tanggal_perawatan = $("#tanggal_perawatan").val();
        if(tanggal_perawatan) {
            document.getElementById("info_tanggal_perawatan").innerHTML = "";
            picker.input.disabled = false;
        }
        let minTime = "";
        let maxTime = "";

        // Kalau tanggal perawatan bukan hari ini,, maka minTime di set dari jam 8
        if (tanggal_hari_ini != tanggal_perawatan) {
            picker.input.disabled = false;
            minTime = "08:00";
            maxTime = "18:30";
            // Kalau tanggal perawatanny hari ini,, maka minTime di set dari jam sekarang + 30 menit
        } else {
            // Kalau hari ini sudah lewat jam tutup
            if(currentHours >= 18) { 
                document.getElementById("info_tanggal_perawatan").innerHTML = "Sudah diluar jam kerja, pilih hari lain";
                picker.input.disabled = true;
            // Kalau hari ini masih di jam buka 
            } else {
                picker.input.disabled = false;
                minTime = `${currentHours}:${currentMinutes + 30}`; // Pasien biso mesen paleng cepet 30 menit dari waktu sekarang
                maxTime = "18:30";
            }
        }
        picker.set({
            maxTime: maxTime,
            minTime: minTime,
        });
    });

</script>
<script>
    const formatRupiah = (money) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }
    $(function() {
        $("#pesan-btn").on("click", function() {
            let tanggalPerawatan = $("#tanggal_perawatan").val();
            let jamPerawatan = $("#jam_perawatan").val() == "" ? "Belum Diisi" : $("#jam_perawatan").val();
            var data = $("#id_status_jasa").val().split('|');
            let tenagaMedis = data[1];
            let hargaTenagaMedis = parseInt(data[2]);
            let jarak = $("#jarak").val();
            let jarak_in_km = Math.round(jarak / 1000);
            let ongkos = 0;
            if (jarak_in_km <= 5) {
                ongkos = 0;
            } else if (jarak_in_km <= 10) {
                ongkos = 15000;
            } else {
                ongkos = ((jarak_in_km - 10) * 3000) + 15000;
            }
            let total = parseInt(ongkos + hargaTenagaMedis);
            $("#tanggalModal").text(formatTanggal(tanggalPerawatan));
            $("#jamModal").text(jamPerawatan);
            $("#tenagaMedisModal").text(tenagaMedis);
            $("#hargaModal").text(formatRupiah(hargaTenagaMedis));
            $("#ongkosModal").text(formatRupiah(ongkos));
            $("#totalModal").text(formatRupiah(total));
        });
    });
</script>
<script>
    const formatTanggal = tanggalInput => {
        let tanggal = tanggalInput.substr(8, 2);
        let bulan = tanggalInput.substr(5, 2);
        let tahun = tanggalInput.substr(0, 4);

        let namaBulan = "";
        switch (bulan) {

            case "01":
                namaBulan = "Januari";
                break;

            case "02":
                namaBulan = "Februari";
                break;

            case "03":
                namaBulan = "Maret";
                break;

            case "04":
                namaBulan = "April";
                break;

            case "05":
                namaBulan = "Mei";
                break;

            case "06":
                namaBulan = "Juni";
                break;

            case "07":
                namaBulan = "Juli";
                break;

            case "08":
                namaBulan = "Agustus";
                break;

            case "09":
                namaBulan = "September";
                break;

            case "10":
                namaBulan = "Oktober";
                break;

            case "11":
                namaBulan = "November";
                break;

            case "12":
                namaBulan = "Desember";
                break;

            default:
                namaBulan = "Belum Diisi";

        }
        return `${tanggal} ${namaBulan} ${tahun}`;
    }
</script>