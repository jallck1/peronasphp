<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Municipio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MunicipioController extends Controller
{
    public function index()
    {
        $municipios = DB::table('tb_municipio')
            ->join('tb_departamento', 'tb_municipio.depa_codi', '=', 'tb_departamento.depa_codi')
            ->select('tb_municipio.*', 'tb_departamento.depa_nomb')
            ->get();
        return json_encode(['municipios' => $municipios]);  
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'muni_nomb' => ['required', 'max:30', 'unique'],
            'depa_codi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $municipio = new Municipio();
        $municipio->muni_nomb = $request->name;
        $municipio->depa_codi = $request->code;
        $municipio->save();

        $municipios = DB::table('tb_municipio')
        ->join('tb_departamento', 'tb_municipio.depa_codi', '=', 'tb_departamento.depa_codi')
        ->select('tb_municipio.*', 'tb_departamento.depa_nomb')
        ->get();
        return json_encode(['municipios' => $municipios]);
    }
    public function show(string $id)
    {
        $municipio = Municipio::find($id);
        if (is_null($municipio)){
            return abort(404);
        }
        $departamentos = DB::table('tb_departamento')
            ->orderBy('depa_nomb')
            ->get();
        return json_encode(['municipio' => $municipio, 'departamentos' => $departamentos]);
    }
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'muni_nomb' => ['required', 'max:30', 'unique'],
            'depa_codi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }

        $municipio = Municipio::find($id);
        if (is_null($municipio)){
            return abort(404);
        }
        $municipio->muni_nomb = $request->name;
        $municipio->depa_codi = $request->code;
        $municipio->save();

        $municipios = DB::table('tb_municipio')
        ->join('tb_departamento', 'tb_municipio.depa_codi', '=', 'tb_departamento.depa_codi')
        ->select('tb_municipio.*', "tb_departamento.depa_nomb")
        ->get();

        return json_encode(['municipios' => $municipios]);
    }
    public function destroy(string $id)
    {
        $municipio = Municipio::find($id);
        if (is_null($municipio)){
            return abort(404);
        }
        $municipio->delete();   

        $municipios = DB::table('tb_municipio')
        ->join('tb_departamento', 'tb_municipio.depa_codi', '=', 'tb_departamento.depa_codi')
        ->select('tb_municipio.*', 'tb_departamento.depa_nomb')
        ->get();
        return json_encode(['municipios' => $municipios]);
    }
}