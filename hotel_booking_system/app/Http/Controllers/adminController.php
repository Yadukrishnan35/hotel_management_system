<?php

namespace App\Http\Controllers;

use App\Models\city;
use App\Models\country;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class adminController extends Controller
{
    public function adminPage() {
        return view('admin.admin_view');
    }

    public function addCountryForm() {
        return view('admin.addCountry');
    }

    public function addCity() {
        $countries = Country::all()->toArray();
        return view('admin.add_city',compact('countries')); 
    }

    public function save_city(Request $request) {
       $city = city::create([
        'name'=>$request->name,
        'country_id'=>$request->country_id
       ]);
    }

    // public function getCountries() {
    //     $countries = country::all();
    //     return view('add_city',compact('countries'));
    // }

    public function saveCountry(Request $request) {
        $rules = [
            'name' => 'required|string|unique:countries,name|max:255',
        ];

        $messages = [
            'name.required' => 'The country name is required.',
            'name.unique' => 'The country name must be unique.',
            'name.max' => 'The country name must not exceed 255 characters.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        country::create([
           'name'=>$request->name,
        ]);
         
        return redirect()->back()->with('success', 'Country added successfully!');
    }
    
    public function cityView() {
        $view_cities = DB::table('cities')
                       ->leftJoin('countries','cities.country_id','=','countries.id')
                       ->select('cities.name as cities_name','countries.name as country_name','cities.id as city_id')
                       ->get();
     $view_cities = json_decode($view_cities,true);

        return view('admin.city_table',compact('view_cities'));
    }

    public function editCity($city_id) {
        $city = DB::table('cities')
    ->join('countries', 'cities.country_id', '=', 'countries.id')
    ->select('cities.name as city_name', 'countries.name as country_name')
    ->where('cities.id',$city_id)
    ->get();
    $city = json_decode($city,true);
         return view('admin.edit_city_form',compact('city'));
    }

    public function deleteCity($city_id) {

        DB::table('cities')->where('id',$city_id)->delete();
        $message = "Deleted successfully";
        return redirect()->route('city_table')->with('success',$message);
    }

    public function getCountries() {
        $country_list = DB::table('countries')->get();
        $country_list = json_decode($country_list,true);
        return response()->json($country_list);
    }
      
    public function searchByCountry(Request $request) {
        $search_name = $request->input('search_name');
        
        $country = DB::table('cities')
                   ->leftJoin('countries','cities.country_id','=','countries.id')
                   ->select('cities.name')
                   ->where('countries.name',$search_name)
                   ->get()
                   ->toArray();
          if(empty($country)) {
            return response()->json(['message'=>'No country exiting']);
          }
          else {
              return response()->json($country);
          }
    }
       

}
