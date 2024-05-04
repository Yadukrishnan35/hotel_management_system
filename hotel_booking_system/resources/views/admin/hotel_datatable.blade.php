<!DOCTYPE html>
<html lang="en">
<head>
    <!-- CSS -->
<link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/2.0.5/css/dataTables.dataTables.min.css">

    <title>Document</title>
</head>
<body>
<table id="myTable" class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>City Name</th>
            <th>Country Name</th>
            <!-- Add more columns as needed -->
        </tr>
    </thead>
    <tbody>
        @foreach($hotel_data as $hotel_datas)
        <tr>
           <td>{{$hotel_datas['hotel_name']}}</td>
           <td>{{$hotel_datas['hotel_desc']}}</td>
           <td>{{$hotel_datas['city_name']}}</td>
           <td>{{$hotel_datas['country_name']}}</td>
        </tr>
       @endforeach
    </tbody>
</table>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/2.0.5/js/dataTables.min.js"></script>
<script>
  $(document).ready(function(e) {
     $("#myTable").DataTable();
  });

</script>

</body>
</html>

    