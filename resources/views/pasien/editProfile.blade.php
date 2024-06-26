<x-inti-layout :title="'Edit Profile'">

    <div class="container">

        <a href="https://wa.me/628117830717" class="wa-float pt-2" target="_blank">
            <div><i class="fa fa-xl fa-whatsapp my-float"></i> <span><strong> &nbsp; Hubungi Kami</strong></span></div>
        </a>

        <div class="py-5">
            <div class="pt-5">
                <div class="pt-5">

                    <!-- Header -->
                    <a href="{{ url('/profile') }}" class="me-3 d-inline"><i class="fa-solid fa-arrow-left"></i></a>
                    <h3 class="montserrat-extra text-start text-shadow pt-4 d-inline">Edit Profile</h3>

                    <div class="mt-4">
                        @if($errors->any())
                        {!! implode('', $errors->all('
                        <div class="text-danger ms-3 mt-2 montserrat-extra"><i class="fa-2xs fa-sharp fa-solid fa-circle"></i> &nbsp; :message </div>
                        ')) !!}
                        @endif
                    </div>

                    <form action="{{ url('profile/update/'.$user->id) }}" method="post" enctype="multipart/form-data" class="mt-4">
                        @method("PATCH")
                        @csrf

                        <div class="form-group">
                            <label for="NIK">NIK</label>
                            <input type="number" name="NIK" id="NIK" placeholder="NIK" onkeydown="return event.keyCode !== 69" onKeyPress="if(this.value.length==16) return false;" min="16" class="form-control my-2" value="{{ old('NIK') ?? $user->NIK }}">
                        </div>

                        <div class="form-group mt-3">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" id="nama" placeholder="nama" class="form-control my-2" value="{{ old('nama') ?? $user->nama }}">
                        </div>

                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="email" class="form-control my-2" value="{{ old('email') ?? $user->email }}">
                        </div>
                        
                        <div class="form-group mt-3">
                            <label for="email">Jenis Kelamin</label>
                            <select class="form-control select2 my-2" id="jenis_kelamin" name="jenis_kelamin" required>
                                <option disabled>Jenis Kelamin</option>
                                <option value="L"
                                    @if($user->jenis_kelamin == "L")
                                    selected = "selected"
                                    @endif>Laki-Laki</option>
                                <option value="P"
                                    @if($user->jenis_kelamin == "P")
                                    selected = "selected"
                                    @endif>Perempuan</option>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="notelp">Nomor Telepon</label>
                            <input type="number" name="notelp" id="notelp" placeholder="notelp" onkeydown="return event.keyCode !== 69" class="form-control my-2" value="{{ old('notelp') ?? $user->notelp }}">
                        </div>

                        <div class="form-group mt-3">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" placeholder="Masukkan tanggal perawatan" class="form-control my-2" max="{{ now()->format('Y-m-d') }}" required value="{{ old('tanggal_lahir') ?? $user->tanggal_lahir}}">
                        </div>

                        <button type="submit" class="btn btn-success mt-3" id="pesan-btn">Update</button>
                    </form>

                </div>
            </div>
        </div>

    </div>

</x-inti-layout>

<link rel="stylesheet" href="{{ asset('css/floatingWA.css') }}">