<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>
<h2>Cities</h2>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif
<table>
  <tr> 
    <th>City</th>
    <th>Country</th>
    <th>Edit</th>
    <th>Delete</th>
  </tr>
  @foreach($view_cities as $city)
  <tr>
    <td>{{$city['cities_name']}}</td>
    <td>{{$city['country_name']}}</td>
    <td><a href="{{ route('edit-city', ['city_id' => $city['city_id']])}}"><i class="fa fa-edit" style="font-size:24px"></i></a></td>
    <td><a href="{{route('delete-city',['city_id'=>$city['city_id']])}}"><i class="fa fa-trash-o" style="font-size:24px"></i></a></td>
  </tr>
  @endforeach
</table>

</body>
</html>