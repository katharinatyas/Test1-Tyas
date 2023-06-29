<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gift;

use Yajra\Datatables\Datatables;

class UltahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query = Gift::all();
            // $data = $query->orderByDesc('created_at')->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '
                    <center>
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit" onclick="edit(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                    <a href="javascript:void(0)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="delete_data(' . $row->id . ')"><i class="fas fa-trash-alt"></i></a>
                    </center>';
                    return $actionBtn;
                })
                ->make(true);
        }
        return view('ulang-tahun', ['title'     => 'Gifts']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (request()->ajax()) {
            Gift::updateOrCreate(
                ['id' => $request->id],
                [
                    'name'  => $request->nama,
                ]
            );
            return response()->json(['status' => true]);
        }
        $nama = $request->input('nama');
        $birthday = $request->input('birthday');
        $today = now()->format('m-d');
        $birthdayDate = \Carbon\Carbon::parse($birthday)->format('m-d');
        if ($today === $birthdayDate) {
            $message = "HELLO " . strtoupper($nama) . " WE WISH YOU HAPPY BIRTHDAY ON " . date('d-m-Y', strtotime($birthday));
            $hadiah = Gift::select('id', 'name')->get();
        } else {
            $message = "Belum ulang tahun";
            $hadiah = null;
        }

        return view('ulang-tahun',  [
            'title'     => 'Gifts',
            'hadiah'    => $hadiah,
            'message'   => $message,
            'nama'      => $nama,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Gift::find($id);

        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gift::find($id)->delete();
        return response()->json(['status' => true]);
    }
}
