<x-admin-layout :title="'Detail Staff Medis'">

    <div class="container">
        <div class="py-5">

            <div class="d-flex">
                <div class="d-inline mt-4 mb-3">
                    <!-- Header -->
                    <a href="{{ url('/daftarStaff') }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
                    <h3 class="montserrat-extra text-start text-shadow pt-4 d-inline">Detail Staff Medis</h3>
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

            <!-- Data Staff Medis -->
            <div class="row mt-5">
                <div class="col-lg-7">
                    <div class="shadow-tipis rounded-card pt-3 pb-4 px-3 mx-2">
                        <div class="d-flex">
                            <div class="montserrat-extra text-start color-inti" style="font-size: larger;">Data Staff Medis</div>
                            <a href="https://wa.me/{{ $staff->notelp }}" class="d-inline justify-content-end ms-auto" target="_blank" rel="noopener">
                                <i class="fa fa-whatsapp fa-2xl" aria-hidden="true" style="color: #25D366"></i>
                            </a>
                        </div>
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <table class="table table-borderless mt-4">
                                    <tbody>
                                        <tr class="montserrat-bold ">
                                            <td>NIP</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->NIK }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>Nama</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->nama }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>Jenis Kelamin</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->getJenisKelamin($staff->jenis_kelamin) }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>Status</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->status_user->status }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>Email</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->email }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>Tanggal Lahir</td>
                                            <td>:</td>
                                            <td class="montserrat-extra color-abu">{{ $staff->getTanggal($staff->tanggal_lahir) }}</td>
                                        </tr>
                                        <tr class="montserrat-bold ">
                                            <td>
                                                <div class="montserrat-extra color-abu {{ $staff->is_active }}-detail text-center mt-4">&nbsp; {{ $staff->status_active($staff->is_active) }}</div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ url('/daftarStaff/updateView/'.$staff->id) }}" class="btn btn-success mt-4 ms-3" id="btn-edit-kecil">Edit</a>
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