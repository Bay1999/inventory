<?php

namespace App\Http\Controllers;

use App\Models\BeliModel;
use App\Models\InventoryModel;
use App\Models\JualModel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['inventories'] = InventoryModel::get();

        return view('home', $data);
    }

    public function create()
    {
        return view('inventory/create');
    }

    public function save(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'harga_barang' => 'required|numeric'
        ]);

        $inventory = new InventoryModel();
        $inventory->nama = $request->nama_barang;
        $inventory->harga = $request->harga_barang;
        $inventory->stok = 5;


        if ($inventory->save()) {
            $return = array(
                'status' => 200
            );
        } else {
            $return = array(
                'status' => 422
            );
        }


        echo json_encode($return);
    }

    public function delete(Request $request)
    {
        // $inventory = InventoryModel::where('inventory_id', $request->id)->delete();

        if (InventoryModel::where('inventory_id', $request->id)->delete()) {
            $return = array(
                'status' => 200
            );
        } else {
            $return = array(
                'status' => 422
            );
        }

        echo json_encode($return);
    }

    public function jual()
    {
        $data['inventories'] = InventoryModel::get();

        return view('inventory/jual', $data);
    }

    public function jualSimpan(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|numeric'
        ]);

        $inventory = InventoryModel::where('inventory_id', $request->nama_barang)->first();

        if ($inventory->stok < $request->jumlah_barang || $request->jumlah_barang < 0) {
            $return = array(
                'status' => 401
            );

            echo json_encode($return);
        } else {
            InventoryModel::where('inventory_id', $request->nama_barang)->update([
                'stok' => $inventory->stok - $request->jumlah_barang
            ]);

            $jual = new JualModel();
            $jual->inventory_id = $request->nama_barang;
            $jual->jumlah = $request->jumlah_barang;

            if ($jual->save()) {
                $return = array(
                    'status' => 200
                );
            } else {
                $return = array(
                    'status' => 422
                );
            }

            echo json_encode($return);
        }
    }

    public function beli()
    {
        $data['inventories'] = InventoryModel::get();

        return view('inventory/beli', $data);
    }

    public function beliSimpan(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jumlah_barang' => 'required|numeric'
        ]);

        $inventory = InventoryModel::where('inventory_id', $request->nama_barang)->first();

        InventoryModel::where('inventory_id', $request->nama_barang)->update([
            'stok' => $inventory->stok + $request->jumlah_barang
        ]);

        $jual = new BeliModel();
        $jual->inventory_id = $request->nama_barang;
        $jual->jumlah = $request->jumlah_barang;

        if ($jual->save()) {
            $return = array(
                'status' => 200
            );
        } else {
            $return = array(
                'status' => 422
            );
        }

        echo json_encode($return);
    }
}
