<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\EmpleadoRol;
use App\Models\Areas;
use App\Models\Roles;
use DataTables;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Roles::get();
        $areas = Areas::pluck('nombre','id')->all();
        $areasAll = Areas::get();
        $empleados = Empleado::get();
        if($request->ajax()){
            $allData = DataTables::of($empleados)
            ->addIndexColumn()
            ->editColumn('area_id', function($row) {
                $area = $row->area_id;
                foreach (Areas::get() as $value) {
                    if($row->area_id == $value->id ){
                        $area = $value->nombre;
                    }
                }
                return $area;
            })
            ->addColumn('modificar',function($row){
                $btn = '<a href"javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Editar" class="edit editEmpleado btn btn-primary btn-sm" style="text-align: center;width: 50px; margin:0 auto; cursor:pointer; display: block;"><i class="far fa-edit"></i></a>';
                return $btn;
            })
            ->addColumn('eliminar',function($row){
                $btn2 = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Borrar" class="delete deleteEmpleado btn btn-danger btn-sm" style="text-align: center;width: 50px; margin:0 auto; cursor:pointer; display: block;"><i class="far fa-trash-alt"></i> </a>';
                return $btn2;
            })
            ->rawColumns(['modificar','eliminar'])
            ->make(true);

            return $allData;
        }

        return view('empleados',compact('empleados','roles','areas','areasAll'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nombre' => 'required',
            'email' => 'required|email',
            'sexo' => 'required',
            'area_id' => 'required',
            'boletin' => 'required',
            'descripcion' => 'required'
        ]);

        $empleado = Empleado::updateOrCreate(
            ['id' => $request->id],
            [
                'nombre' => $request->nombre,
                'email' => $request->email,
                'sexo' => $request->sexo,
                'area_id' => $request->area_id,
                'boletin' => $request->boletin,
                'descripcion' => $request->descripcion
            ],
        );

        $old_roles = EmpleadoRol::where('empleado_id',$request->id)->get('rol_id');

        foreach($request->roles as $item){
            EmpleadoRol::updateOrCreate(
                [
                    'empleado_id' => $empleado->id,
                    'rol_id' => $item
                ],
            );
        }

        return response()->json(['success'=>'Empleado creado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleados  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleados  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empleado = Empleado::find($id);
        $roles = EmpleadoRol::where('empleado_id',$id)->get('rol_id');
        $datos = [
            'empleado'=>$empleado,
            'roles'=>$roles
        ];
        return response()->json($datos);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleados  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleados  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Empleado::find($id)->delete();
        return response()->json(['success'=>'Empleado eliminado correctamente']); 
    }
}
