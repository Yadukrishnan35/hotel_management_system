<?php

namespace App\Http\Controllers;

use App\Models\hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Raw;

class homeController extends Controller
{
    public function index() {
        $city_country = DB::table('hotels as h')
        ->join('cities as c', 'c.id', '=', 'h.city_id')
        ->join('countries as cn', 'cn.id', '=', 'c.country_id')
        ->select(DB::raw("CONCAT(c.name, '-', cn.name) as city_country"))
        ->Distinct()
        ->get();
        $city_country=json_decode($city_country);
        $count = DB::table('hotels')->count();
    
     return view('Frontend.home',compact('city_country'));
    }

    public function display_hotel_data(Request $request) {
        
     //Read Values
     $draw = $request->get('draw');
     $start = $request->get('start');
     $rowPerPage = $request->get('length');
     $columnIndexArr = $request->get('order');
     $columnNamesArr = $request->get('columns');
     $order_arr = $request->get('order');
     $search_arr = $request->get('search');
     $columnName  = $columnNamesArr[$columnIndex]['data'];
     $columnSortOrder = $order_arr[0]['dir']; //asc or desc
     $search_value = $search_arr['value'];
    //TotalRecords 
    //  $total_records = hotel::select('name','description','city_id');
    $total_records = hotel::select('count(*) as all_count')->count();
    //Total Records with search Filter
    $total_records_filter = hotel::select('count(*) as all_count')
                            ->where('name','like','%'.$search_value.'%')
                            ->count();
    //Fetch Records
    $records = hotel::orderby($columnName,$columnSortOrder)
               ->where('hotel.name','like','%'.$search_value.'%')
               ->select('hotel.*')
               ->skip($start)
               ->take($rowPerPage)
               ->get();
        $data_arr = array();
        foreach($records as $record) {
          $id = $record->id;
          $name = $record->name;
          $description = $record->description;

          $data_arr[] = array(
          "id" => $id,
          'name' => $name,
           'description' => $description
          
          );
        }
        $response = array(
           "draw" =>intval($draw),
           "TotalRecords" => $total_records,
           "TotalDisplayRecords" => $total_records_filter,
           "aaData"=>$data_arr
        );
        echo json_encode($response);
        return view('Frontend.display_hotel');

        exit;
    }
}
