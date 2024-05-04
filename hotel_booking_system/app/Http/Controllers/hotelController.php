<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\country;
use App\Models\hotel;
use App\Models\room_type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class hotelCOntroller extends Controller
{
     public function addHotelForm() {
       
      // $cities = city::select('id','name')
      // ->with(['country' => function($query) {
      //    $query->select('id','name');
      // }])
      // ->get()
      // ->toArray();

      // $cities = city::with('country')->get()->toArray();
       $cities = city::with('country')->get()->toArray();
       
       return view('admin.add_hotel',compact('cities'));
     }

public function save_hotel_data(Request $request) {
       
      $hotel = hotel::create([
         'name' => $request->input('name'),
         'description' => $request->input('description'),
         'city_id'=>$request->input('cities')
      ]);
   
      return response()->json(["saved Successfully",$hotel]);
   
   }

   public function viewHotel() {
      // $hotel_names = hotel::select('name')->get()->toArray();
      // $uppercase_names =  array_map([$this, 'hotel_names_uppercase'], $hotel_names);
     
      // $all_hotel = hotel::with(['city','city.country'=>function($query){
      //         $query->select('id','name'); 
      // }])->get()->toArray();

      $all_hotel = DB::table('hotels')
                   ->leftjoin('cities','cities.id','=','hotels.city_id')
                   ->leftjoin('countries','countries.id','=','cities.country_id')
                   ->select('hotels.id as hotel_id',
                            'hotels.name as hotel_name',
                            'hotels.description as hotel_desc',
                            'cities.id as city_id',
                            'cities.name as city_name',
                            'countries.id as country_id',
                            'countries.name as country_name',
                            DB::raw("DATE_FORMAT(hotels.created_at,'%d-%m-%Y') as created_at")
                          )->get();
         $all_hotel = json_decode($all_hotel,true);
         return $all_hotel;
      return view('admin.hotelView',compact('all_hotel'));
   }
   
   /* Returns name in upper case */
   public function hotel_names_uppercase($names) {
        $names = json_encode($names);
        return strtoupper($names);
   }
   
   /*Get Hotel data*/
   public function get_hotel_data(Request $request) {
      //dd($request->all());
      $hotel_id = $request->hotelId;
      $country_id = $request->countryId;
      $all_cities = city::all()->toArray();
      $all_countries = country::all()->toArray();
      $hotel_data = DB::table('hotels')->where('hotels.id',$hotel_id)
                    ->leftjoin('cities','cities.id','=','hotels.city_id')
                    ->leftjoin('countries','countries.id','=','cities.country_id')
                    ->where('countries.id',$country_id)
                    ->select('hotels.id as hotel_id',
                              'hotels.name as hotel_name',
                              'hotels.description as desc',
                              'cities.name  as city_name',
                              'countries.name as country_name',                              
                              'cities.id as city_id',
                              'countries.id as country_id',
                     )
                    ->first();
       return response()->json(['data'=>$hotel_data,'city'=>$all_cities,'countries'=>$all_countries]);
   
   }

   /* Update Hotel */
   public function updateHotel(Request $request) {
      //dd($request->all());
      $hotel_data = hotel::where('id',$request->hotel_id)->update([
                          'name' => $request->hotel_name,
                          'description' => $request->hotel_desc,
                           'city_id' => $request->city_id,
                     ]);

      return response()->json(["msg"=>"Data updated successfully"]);


   }

   /* Delete Hotel */
   public function delete_hotel(Request $request) {
      $hotel_id = $request->hotel_id;
      $hotel_delete = hotel::where('id',$hotel_id)->delete();
      $hotel_delete = DB::table('hotels')->where('id',$hotel_id)->delete();
      return response()->json(['msg'=>'Data deleted']);
   }
   
   /*Code to find count of searched Hotel */
   public function countOfHotels($hotel_name) {
        //$hotel_name = $request->hotel_name;
       $count_of_hotels = hotel::where('name',$hotel_name)->count();
       return $count_of_hotels;
       
   }

   /* Function to check hotel existing or not */
   public function search_hotel(Request $request) {
      try {
          $hotel_controller = new hotelCOntroller(); 
          $search_name = $request->hotel_name;
  
          $check_exist = hotel::where('name',$search_name)->exists();
  
          if ($check_exist) {
              $hotel_details =  hotel::where('name',$search_name)->get()->toArray();
              $count = $hotel_controller->countOfHotels($search_name);
              return response()->json(['msg' => "existing...",'count'=>$count,'result'=>$hotel_details]);
          } else {
              return response()->json(['msg' => " not existing..."]);
          }
      } catch (Exception $e) {
          // Log the error with the line number
          $errorLine = $e->getLine();
          error_log("Error occurred at line $errorLine: " . $e->getMessage());  // Need to configure error logs to work this 
          return response()->json("error");
      }
  }
   
  public function searchByCity(Request $request) {
      $city_name = $request->city_name;
      $data = hotel::whereHas('city',function($query) use($city_name) {
               $query->where('name','like',$city_name);
      });
      //dd($data);
  }
   public function get_countries() {
      $countries = DB::table('countries')->select('name')->get();
      $countries = json_decode($countries,true);
      //$countries = array_merge($countries);
      return response()->json(["available countries"=>$countries]);

      //dd($countries);  
   }

   public function gethoteldetails() {
      $hotel_data = $this->viewHotel();
      // return response()->json(["hotel_data"=>$hotel_data]);
      
      return view('admin.hotel_datatable',compact('hotel_data'));
   }
   
   // public function addRoomType() {
   //    return view('admin.add_room_types');
   // }
   
   // public function save_room_type($data) {
   //    room_type::create($data);
   // } 
   
   public function edit_room_type($id) {

   }

   public function delete_room_type($id) {
      

   } 

   public function room_type_crud(Request $request) {
      $data= $request->all();
      $action  = $data['action'];
      unset($data['_token']);

      switch($action) {
         case 'add':  $this->save_room_type($data);
            break;
         case 'edit': $this->edit_room_type($request->id);
            break;
         case 'delete':$this->delete_room_type($request->id);
             break;
         default: break;  
      }
      

      
      
   }



}  