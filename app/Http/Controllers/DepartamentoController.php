<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$departamentos = Department::all();
        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return view('departamento.index', ['departamentos' => $departamentos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paises = DB::table('tb_pais')
            ->orderBy('pais_nomb')
            ->get();
        return view('departamento.new', ['paises' => $paises]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $departamento = new Department();
        $departamento->depa_nomb = $request->name;
        $departamento->pais_codi = $request->code;
        $departamento->save();

        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return view('departamento.index', ['departamentos' => $departamentos]);
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
        $departamento = Department::find($id);
        $paises = DB::table('tb_pais')
            ->orderBy('pais_nomb')
            ->get();
        return view('departamento.edit', ['departamento' => $departamento, 'paises' => $paises]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $departamento = Department::find($id);

        $departamento->depa_nomb = $request->name;
        $departamento->pais_codi = $request->code;
        $departamento->save();  

        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return view('departamento.index', ['departamentos' => $departamentos]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departamento = Department::find($id);
        $departamento->delete();   

        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return view('departamento.index', ['departamentos' => $departamentos]);
    }
}
