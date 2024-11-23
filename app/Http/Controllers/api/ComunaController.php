<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Comuna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ComunaController extends Controller
{
    public function index()
    {
        $comunas = DB::table('tb_comuna')
            ->join('tb_municipio', 'tb_comuna.muni_codi', '=', 'tb_municipio.muni_codi')
            ->select('tb_comuna.*', "tb_municipio.muni_nomb")
            ->get();
        return json_encode(['comunas'=>$comunas]);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'comu_nomb' => ['required', 'max:30', 'unique'],
            'muni_codi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }

        $comuna = new Comuna();
        $comuna->comu_nomb = $request->name;
        $comuna->muni_codi = $request->code;
        $comuna->save();
        $comunas = DB::table('tb_comuna')
            ->join('tb_municipio', 'tb_comuna.muni_codi', '=', 'tb_municipio.muni_codi')
            ->select('tb_comuna.*', "tb_municipio.muni_nomb")
            ->get();

        return json_encode(['comunas'=>$comunas]);
    }
    public function show($id)
    {
        $comuna = Comuna::find($id);
        if (is_null($comuna)){
            return abort(404);
        }
        $municipios = DB::table('tb_municipio')
            ->orderBy('muni_nomb')
            ->get();
        return json_encode(['comuna' => $comuna, 'municipios' => $municipios]);
    }
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'comu_nomb' => ['required', 'max:30', 'unique'],
            'muni_codi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $comuna = Comuna::find($id);
        if (is_null($comuna)){
            return abort(404);
        }
        $comuna->comu_nomb = $request->name;
        $comuna->muni_codi = $request->code;
        $comuna->save();

        $comunas = DB::table('tb_comuna')
            ->join('tb_municipio', 'tb_comuna.muni_codi', '=', 'tb_municipio.muni_codi')
            ->select('tb_comuna.*', "tb_municipio.muni_nomb")
            ->get();

        return json_encode(['comunas'=>$comunas]);
    }
    public function destroy(string $id)
    {
        $comuna = Comuna::find($id);
        if (is_null($comuna)){
            return abort(404);
        }
        $comuna->delete();
        $comunas = DB::table('tb_comuna')
        ->join('tb_municipio', 'tb_comuna.muni_codi', '=', 'tb_municipio.muni_codi')
        ->select('tb_comuna.*', "tb_municipio.muni_nomb")
        ->get();
        
        return json_encode(['comunas' => $comunas]);
    }
}