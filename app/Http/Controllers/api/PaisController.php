<?php

namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Pais;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaisController extends Controller
{

    public function index()
    {
        $paises = DB::table('tb_pais')
        ->join('tb_municipio', 'tb_pais.pais_capi', '=', 'tb_municipio.muni_codi')
        ->select('tb_pais.*', 'tb_municipio.muni_nomb')
        ->get();
        return json_encode(['paises' => $paises]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'pais_nomb' => ['required', 'max:30', 'unique'],
            'pais_capi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $pais = new Pais();
        $pais->pais_codi = $request->id;
        $pais->pais_nomb = $request->name;
        $pais->pais_capi = $request->code;
        $pais->save();
        $paises = DB::table('tb_pais')
         ->join('tb_municipio', 'tb_pais.pais_capi', '=', 'tb_municipio.muni_codi')
         ->select('tb_pais.*', 'tb_municipio.muni_nomb')
         ->get();
         return json_encode(['paises' => $paises]);
    }
    public function show(string $id)
    {
        $pais = Pais::find($id);
        if (is_null($pais)){
            return abort(404);
        }
        $municipios =DB::table('tb_municipio')
        ->orderBy('muni_nomb')
        ->get();
        return json_encode(['pais'=>$pais, 'municipios'=>$municipios]);
    }
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'pais_nomb' => ['required', 'max:30', 'unique'],
            'pais_capi' => ['required', 'numeric', 'min:1']
        ]);
        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $pais = Pais::find($id);
        if (is_null($pais)){
            return abort(404);
        }
        $pais->pais_nomb = $request->name;
        $pais->pais_capi = $request->code;
        $pais->save();

        $paises = DB::table('tb_pais')
        ->join('tb_municipio','tb_pais.pais_capi','=','tb_municipio.muni_codi')
        ->select('tb_pais.*',"tb_municipio.muni_nomb")
        ->get();
        return json_encode(['paises'=>$paises]);
    }
    public function destroy(string $id)
    {
        $pais= Pais::find($id);
        if (is_null($pais)){
            return abort(404);
        }
        $pais->delete();
        $paises = DB::table('tb_pais')
        ->join('tb_municipio','tb_pais.pais_capi','=','tb_municipio.muni_codi')
        ->select('tb_pais.*',"tb_municipio.muni_nomb")
        ->get();
        return json_encode(['paises'=>$paises]);
    }
}