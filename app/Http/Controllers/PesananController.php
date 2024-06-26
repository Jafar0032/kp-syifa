<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\StatusUser;
use App\Models\Layanan;
use App\Models\Alamat;
use App\Models\HargaLayanan;
use App\Models\StatusPesanan;
use App\Models\Users;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use DateTime;
use File;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function detail_admin($id)
    {
        $this->authorize('detailPesanan', Pesanan::class);
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        $time = $pesanan->jam_perawatan; // Tipe data waktu dalam format HH:MM:SS
        $interval = 2; // Jumlah jam yang ingin ditambahkan
        $originalTime = DateTime::createFromFormat('H:i:s', $time);
        $originalTime->modify("+{$interval} hours");
        $newTime = $originalTime->format('H:i:s');
        $cek_jasa_INpesanan = Pesanan::where('tanggal_perawatan','=',$pesanan->tanggal_perawatan)->where('jam_perawatan','>=',$pesanan->jam_perawatan)->where('jam_perawatan','<=',$newTime)->where('id','!=',$id)->get();
        return view("admin.pesanan.detailPesanan",compact('pesanan', 'nikJasa','cek_jasa_INpesanan'));
    }

    public function detail_pasien($id)
    {
        if(auth()->user()->status !== 'P') {
            abort(401);
        }
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        return view("pasien.pesanan.detail",compact('pesanan', 'nikJasa'));
    }

    public function konfirmasi_admin(Request $request, $id){
        $pesanan = Pesanan::find($id);
        $pesanan->id_status_pesanan = "SB";
        $pesanan->save();
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        return redirect()->route("pesanan.detail",['id'=>$id]);
    }

    public function tolak_admin(Request $request, $id){
        $pesanan = Pesanan::find($id);
        $pesanan->id_status_pesanan = "T";
        $pesanan->save();
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        return redirect()->route("pesanan.detail",['id'=>$id]);
    }

    public function selesai_admin(Request $request, $id){
        $pesanan = Pesanan::find($id);
        $pesanan->id_status_pesanan = "S";
        $pesanan->save();
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        return redirect()->route("pesanan.detail",['id'=>$id]);
    }

    public function hapuspembayaran_admin(Request $request, $id){
        $pesanan = Pesanan::find($id);
        File::delete("public/buktipembayaran/". $pesanan->bukti_pembayaran);
        $pesanan->bukti_pembayaran = NULL;
        $pesanan->status_pembayaran = 'T';
        $pesanan->save();
        $pesanan = Pesanan::find($id);
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->get();
        return redirect()->route("pesanan.detail",['id'=>$id]);
    }
    public function addView($id)
    {
        if(auth()->user()->status !== 'P') {
            abort(401);
        }
        $layanan = Layanan::find($id);
        $jasa = HargaLayanan::where('id_layanan', '=', $id)->get();
        $alamat = Alamat::where('id_user', '=', Auth::user()->id)->get();
        return view("pasien.pesanan.add",compact('layanan','jasa','alamat'));        
    }
    public function add(Request $request,$id)
    {
        // dd($request->foto->getClientOriginalExtension());
        $layanan = Layanan::find($id);
        $validation = $request->validate([
            'id_status_jasa' =>'required',
            'alamat' =>'required',
            'foto' => 'file|image',
            'tanggal_perawatan' =>'required',
            'jam_perawatan' =>'required',
        ],
        [
            'id_status_jasa.required' => 'Silahkan pilih jasa yang anda inginkan !',
            'alamat.required' => 'Silahkan isi alamat anda !',
            'tanggal_perawatan.required' => 'Silahkan pilih tanggal untuk perawatan !',
            'jam_perawatan.required' => 'Silahkan pilih waktu untuk perawatan !',
        ]);
        $optionValues = explode('|', $request->id_status_jasa);
        $jasa = $optionValues[0];
        $pesanan = new Pesanan();
        if($request->foto)
        {
            $nama_file = Auth::user()->id.'-'.time().".jpg";
            $foto = Image::make($request->foto);
            $foto->save('public/foto_pesanan/' . $nama_file, 20, 'jpg');
            $pesanan->foto = $nama_file;
        }
        $hargajasalayanan = HargaLayanan::where('id_layanan', '=', $id)
        ->where('id_status_jasa', '=', $jasa)
        ->get();
        $tbalamat = Alamat::find($request->alamat);
        $jarak =  round($tbalamat->jarak/1000);
        $alamat = $tbalamat->alamat; 
        $detailalamat = $tbalamat->detail;

        $pesanan->id_pasien = Auth::user()->id;
        $pesanan->notelp_pasien = Auth::user()->notelp;
        $pesanan->id_layanan = $layanan->id;
        $pesanan->id_status_jasa = $jasa;
        $pesanan->id_status_pesanan = "M";
        $pesanan->alamat = $alamat."; ".$detailalamat;
        $pesanan->harga = $hargajasalayanan[0]->harga;
        if($jarak<=5){
            $pesanan->ongkos = 0;
        }else if($jarak<=10){
            $pesanan->ongkos = 15000;
        }else{
            $pesanan->ongkos = (($jarak-10)*3000)+15000;
        }
        $pesanan->keluhan = $request->keluhan;       
        $pesanan->status_pembayaran = "T"; 
        $pesanan->tanggal_perawatan = $request->tanggal_perawatan;
        $pesanan->jam_perawatan = $request->jam_perawatan;
        date_default_timezone_set('Asia/Jakarta');
        $pesanan->created_at = date('Y-m-d H:i:s');

        $pesanan->save();
        $request->session()->flash("info","Pesanan berhasil dibuat! Silahkan tunggu konfirmasi dari admin");

        $pesanan = Pesanan::find($pesanan->id);
        return view("pasien.pesanan.detail",compact('pesanan'));
    }
    public function getStatusJasa($id)
    {
        $status_jasa = HargaLayanan::where('id_layanan',$id)->with('status_user')->get();
        return response()->json($status_jasa);
    }
    public function getNikJasa($id)
    {
        $nik_jasa = Users::where('status',$id)->where('is_active', '=', 'Y')->get();
        return response()->json($nik_jasa);
    }
    public function updateView(Request $request, $id)
    {
        $this->authorize('updatePesanan', Pesanan::class);
        $pesanan = Pesanan::find($id);        
        $nikJasa = Users::where('status', '=', $pesanan->id_status_jasa)->where('is_active', '=', 'Y')->get();
        $statusJasa = HargaLayanan::where('id_layanan',$pesanan->id_layanan)->get();
        $layanan = Layanan::all();
        $statusPesanan = StatusPesanan::all();
        $coba = $pesanan->id_layanan;        
        return view("admin.pesanan.update",compact('pesanan','layanan','statusJasa','nikJasa','statusPesanan','coba'));
    }
    public function updateByAdmin(Request $request, $id, Pesanan $pesanan)
    {
        $this->authorize('updatePesanan', Pesanan::class);
        $validation = $request->validate([
            'foto' => 'file|image',
            'status_jasa' =>'required',
            'id_jasa' =>'required',
            'alamat' => 'required'
        ],
        [
            'status_jasa.required' => 'Silahkan pilih jasa !',
            'id_jasa.required' => 'Silahkan pilih staff medis !',
            'alamat.required' => 'Alamat wajib diisi!'
        ]);
        $hargajasalayanan = HargaLayanan::where('id_layanan', '=', $request->layanan)
        ->where('id_status_jasa', '=', $request->status_jasa)
        ->get();

        $pesanan = Pesanan::find($id);
        
        if($request->id_status_pesanan == 'S' && $pesanan->bukti_pembayaran == NULL){
            $error = "Jika ingin menyelesaikan pesanan silahkan upload bukti pembayaran";
            return redirect()->back()->withErrors($error);
        }
        if($request->foto)
        {
            $nama_file = Auth::user()->id.'-'.time().".jpg";
            $foto = Image::make($request->foto);
            $foto->save('public/foto_pesanan/' . $nama_file, 20, 'jpg');
            $pesanan->foto = $nama_file;
        } 
        if($request->bukti_pembayaran)
        {
            $nama_file = Auth::user()->id.'-'.time().".jpg";
            $foto = Image::make($request->bukti_pembayaran);
            $foto->save('public/bukti_pembayaran/' . $nama_file, 15, 'jpg');
            $pesanan->bukti_pembayaran = $nama_file;
        }        
        $pesanan->id_layanan = $request->layanan;
        $pesanan->id_status_jasa = $request->status_jasa;
        $pesanan->id_jasa = $request->id_jasa;
        $pesanan->alamat = $request->alamat;
        $pesanan->keluhan = $request->keluhan;
        $pesanan->harga = $hargajasalayanan[0]->harga;
        $pesanan->id_status_pesanan = $request->id_status_pesanan;
        if($pesanan->bukti_pembayaran){
            $pesanan->status_pembayaran = 'Y';
        }else{
            $pesanan->status_pembayaran = 'T';
        }
        
        $pesanan->tanggal_perawatan = $request->tanggal_perawatan;

        // kalau jam_perawatannya sudah dalam bentuk hh:mm:ss
        if(strlen(strval($request->jam_perawatan)) > 5){
            $pesanan->jam_perawatan = $request->jam_perawatan;
        } 
        // kalau jam_perawatannya masih dalam bentuk hh:mm
        else {
            $pesanan->jam_perawatan = $request->jam_perawatan.":00";
        }

        $pesanan->save();
        $pesanan = Pesanan::find($id);
        $request->session()->flash("info","Pesanan ini berhasil diupdate!");
        return view("admin.pesanan.detailPesanan",compact('pesanan'));
    }

    public function updatePerawatByAdmin(Request $request, $id, Pesanan $pesanan)
    {
        $pesanan = Pesanan::find($id);
        $pesanan->id_jasa = $request->id_jasa;
        $pesanan->save();
        return redirect()->route("pesanan.detail",['id'=>$id]);
    }

    public function batalPesanan($id, Pesanan $pesanan)
    {
        $pesanan = Pesanan::find($id);   
        $pesanan->id_status_pesanan = "B";
        $pesanan->save();

        return redirect()->route("pasien.profile");
    }
    
    public function konfirmasiKedatangan($id, Pesanan $pesanan)
    {
        $pesanan = Pesanan::find($id);   
        $pesanan->id_status_pesanan = "TD";
        $pesanan->save();

        return redirect()->route("pasien.profile");
    }
}
