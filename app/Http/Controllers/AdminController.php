<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Layanan;
use App\Models\Users;
use App\Models\StatusUser;
use App\Models\Pesanan;
use App\Models\StatusLayanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function daftarStaff(){
        $staff = Users::where('status', '!=', 'P')->get();
        $statusStaff = StatusUser::where('id','!=','P')->get();
        $reqselected = ['all'];
        return view("admin.staff.daftarStaff",compact('staff','statusStaff','reqselected'));
    }
    public function daftarStaffFilter(Request $request){
        if($request->status_staff == "all"){
            $staff = Users::all();
        }else{
            $staff = Users::where('status', '=', $request->status_staff)->get();
        }
        $statusStaff = StatusUser::where('id','!=','P')->get();
        $reqselected = [$request->status_staff];
        return view("admin.staff.daftarStaff",compact('staff','statusStaff','reqselected'));
    }
    public function daftarPasien(){
        $pasien = Users::where('status', '=', 'P')->get();
        return view("admin.pasien.daftarPasien",compact('pasien'));
    }
    public function daftarLayananFilter(Request $request){
        
        if($request->show == "all"){
            $layanan = Layanan::all();
        }else{
            $layanan = Layanan::all();
            $layanan = Layanan::where('show', '=', $request->show)->get();
        }
        $reqselected = [$request->show];
        return view("admin.layanan.daftarLayanan",compact('layanan','reqselected'));
    }
    public function daftarLayanan(){
        $layanan = Layanan::all();
        $reqselected = ['all'];
        return view("admin.layanan.daftarLayanan",compact('layanan','reqselected'));
    }
    public function daftarStatusStaff(){
        $statusStaff = StatusUser::where('status', '!=', 'P')->get();
        return view("admin.statusUser.daftarStatusStaff",compact('statusStaff'));
    }
    public function daftarPesanan(){
        $pesanan = Pesanan::where('id_status_layanan', '=', 'M')->paginate(10);
        // dump($pesanan);
        $statuspesanan = StatusLayanan::all();
        $layanans = Layanan::all();
        $reqselected = ['M','all','all'];
        return view("admin.pesanan.daftarPesanan",compact('pesanan','statuspesanan','layanans','reqselected'));
    }
    public function daftarPesananFilter(Request $request){
        $pesanan = Pesanan::where('id_status_layanan', '=', 'M')->paginate(10);
        if($request->id_status_layanan == "all" && $request->id_layanan == "all" && $request->status_pembayaran == "all")
        {
            $pesanan = Pesanan::paginate(10);
        }else if($request->id_status_layanan !== "all" && $request->id_layanan == "all"  && $request->status_pembayaran == "all")
        {
            $pesanan = Pesanan::where('id_status_layanan', '=', $request->id_status_layanan)->paginate(10);
        }else if($request->id_status_layanan == "all" && $request->id_layanan !== "all"  && $request->status_pembayaran == "all")
        {
            $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)->paginate(10);
        }else if($request->id_status_layanan == "all" && $request->id_layanan == "all" && $request->status_pembayaran !== "all")
        {
            $pesanan = Pesanan::where('status_pembayaran', '=', $request->status_pembayaran)->paginate(10);
        }else if($request->id_status_layanan !== "all" && $request->id_layanan == "all" && $request->status_pembayaran !== "all")
        {
            $pesanan = Pesanan::where('status_pembayaran', '=', $request->status_pembayaran)
            ->where('id_status_layanan', '=', $request->id_status_layanan)->paginate(10);
        }else if($request->id_status_layanan == "all" && $request->id_layanan !== "all" && $request->status_pembayaran !== "all")
        {
            $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)
            ->where('status_pembayaran', '=', $request->status_pembayaran)->paginate(10);
        }else if($request->id_status_layanan !== "all" && $request->id_layanan !== "all" && $request->status_pembayaran == "all")
        {
            $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)
            ->where('id_status_layanan', '=', $request->id_status_layanan)->paginate(10);
        }else if($request->id_status_layanan !== "all" && $request->id_layanan !== "all" && $request->status_pembayaran !== "all")
        {
            $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)
            ->where('id_status_layanan', '=', $request->id_status_layanan)
            ->where('status_pembayaran', '=', $request->status_pembayaran)->paginate(10);
        }

        // nested if
        // if($request->id_status_layanan == "all"){
        //     if($request->id_layanan == "all"){
        //         if($request->status_pembayaran == "all"){
        //             $pesanan = Pesanan::all();
        //         }else{
        //             $pesanan = Pesanan::where('status_pembayaran', '=', $request->status_pembayaran)->get();
        //         }
        //     }else{
        //         if($request->status_pembayaran == "all"){
        //             $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)->get();
        //         }else{
        //             $pesanan = Pesanan::where('id_status_layanan', '=', $request->id_status_layanan)
        //             ->where('status_pembayaran', '=', $request->status_pembayaran)->get();
        //         }
        //     }
        // }else{
        //     if($request->id_layanan == "all"){
        //         if($request->status_pembayaran == "all"){
        //             $pesanan = Pesanan::where('id_status_layanan', '=', $request->id_status_layanan)->get();
        //         }else{
        //             $pesanan = Pesanan::where('status_pembayaran', '=', $request->status_pembayaran)
        //             ->where('id_status_layanan', '=', $request->id_status_layanan)->get();
        //         }
        //     }else{
        //         if($request->status_pembayaran == "all"){
        //             $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)
        //             ->where('id_status_layanan', '=', $request->id_status_layanan)->get();
        //         }else{
        //             $pesanan = Pesanan::where('id_layanan', '=', $request->id_layanan)
        //             ->where('id_status_layanan', '=', $request->id_status_layanan)
        //             ->where('status_pembayaran', '=', $request->status_pembayaran)->get();
        //         }
        //     }
        // }
        
        // dd($pesanan);
        $statuspesanan = StatusLayanan::all();
        $reqselected = [$request->id_status_layanan,$request->id_layanan,$request->status_pembayaran];
        $layanans = Layanan::all();
        
        return view("admin.pesanan.daftarPesanan",compact('pesanan','statuspesanan','layanans','reqselected'));
    }
}