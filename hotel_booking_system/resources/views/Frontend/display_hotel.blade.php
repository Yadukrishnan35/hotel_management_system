<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!---Data table Css --->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
     <!---Data table Js--->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
</head>
<body>
<table id="hotel_table" border="1" width="100%" style="border-collapse:collapse;">
   <thead>
       <td>Id</td>
       <td>Name</td>
       <td>Description</td>
   </thead>
</table>
    <script type="text/javascript">
       $('#hotel_table').Datatable({
           Processing:true,
           serverSide:true,
           ajax:"{{route('frontend.display_hotel')}}",
           columns: [
            {data:'id'},
            {data:'name'},
            {data:'description'}
           ]
       });
    </script>
</body>
</html>