<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function trabajador(Request $request){

      if (request('cedula')){
          $trabajador = DB::connection('sigefirrhh')->select(
            "select * from trabajador where cedula = :cedula and id_trabajador in (
             select id_trabajador from (select cedula, max(id_trabajador) as id_trabajador
            from trabajador group by cedula) a)", array(
                'cedula' => request('cedula'),
          ));

      }else{
        $trabajador = DB::connection('sigefirrhh')->select(
          "select * from trabajador where id_trabajador in (
           select id_trabajador from (select cedula, max(id_trabajador) as id_trabajador
          from trabajador group by cedula) a)");
      }
      return response(['data' => $trabajador], 200, [], JSON_NUMERIC_CHECK);
    }
}
