<?php
namespace App\Http\Controllers\api;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return json_encode(['departamentos' => $departamentos]);
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'depa_nomb' => ['required', 'max:30', 'unique'],
            'pais_codi' => ['required', 'numeric', 'min:1']
        ]);
      if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $departamento = new Department();
        $departamento->depa_nomb = $request->name;
        $departamento->pais_codi = $request->code;
        $departamento->save();
        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return json_encode(['departamentos' => $departamentos]);
    }
    public function show(string $id)
    {
        $departamento = Department::find($id);
        if (is_null($departamento)){
            return abort(404);
        }
        $paises = DB::table('tb_pais')
            ->orderBy('pais_nomb')
            ->get();
        return json_encode(['departamento' => $departamento, 'paises' => $paises]);
    }
    public function update(Request $request, string $id)
    {
        $validate = Validator::make($request->all(), [
            'depa_nomb' => ['required', 'max:30', 'unique'],
            'pais_codi' => ['required', 'numeric', 'min:1']
        ]);

        if ($validate->fails()){
            return response()->json([
                'msg' => 'Se produjo un error en la validacion de la informacion.',
                'statusCode' => 400
            ]);
        }
        $departamento = Department::find($id);
        if (is_null($departamento)){
            return abort(404);
        }
        $departamento->depa_nomb = $request->name;
        $departamento->pais_codi = $request->code;
        $departamento->save();  
        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return json_encode(['departamentos' => $departamentos]);
    }
    public function destroy(string $id)
    {
        $departamento = Department::find($id);
        if (is_null($departamento)){
            return abort(404);
        }
        $departamento->delete();   

        $departamentos = DB::table('tb_departamento')
        ->join('tb_pais', 'tb_departamento.pais_codi', '=', 'tb_pais.pais_codi')
        ->select('tb_departamento.*', 'tb_pais.pais_nomb')
        ->get();
        return json_encode(['departamentos' => $departamentos]);
    }
}