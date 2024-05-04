<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Laravel 5.8 Ajax CRUD Application - 
DevOpsSchool.com </title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
 <style>
   .container{
    padding: 0.5%;
   } 
</style>
</head>
<body>
 
<div class="container">
    <h2 style="margin-top: 12px;" class="alert alert-success">All Hotels</h2><br>
    <div class="row">
        <div class="col-12">
          <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-post">Add post</a> 
          
          <table class="table table-bordered" id="laravel_crud">
           <thead>
              <tr>
                 <th>Sr.no</th>
                 <th>Name</th>
                 <th>Description</th>
                 <th>City</th>
                 <th>Country</th>
                 <th>Created At</th>
                                 
                 <th colspan="2">Action</th>
              </tr>
           </thead>
           <tbody id="posts-crud">
              @php
                $i = 1;
              @endphp
              
              @foreach($all_hotel as $hotel)
              <tr id="">
                 <td>{{$hotel['hotel_id']}}
                 <td>{{ $hotel['hotel_name'] }}</td>
                 <td>{{ $hotel['hotel_desc'] }}</td>
                 <td>{{ $hotel['city_name']}}</td>
                 <td>{{ $hotel['country_name']}}</td>
                 <td>{{ $hotel['created_at']}}
                 <input type="hidden" class="country-id" value="{{ $hotel['country_id'] }}">
                 <td><a href="" data-id="{{ $hotel['hotel_id'] }}"  class="btn btn-info edit-post">Edit</a></td>
                 <td><a href=""  data-id="{{ $hotel['hotel_id'] }}" class="btn btn-danger delete-post">Delete</a></td>
              </tr>
              @php
                $i++;
              @endphp
              @endforeach
              
           </tbody>
          </table>
          
       </div> 
    </div>
</div>
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="postCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="hotelupdate" name="postForm" class="form-horizontal">
           <input type="hidden" name="hotel_id" id="hotel_id" value="">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="hotel_name" name="hotel_name" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="desc" name="hotel_desc" value="" required="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">City</label>
                <div class="col-sm-12">
                    <input type="hidden" name="city_id" id="city_id">
                    <select class="form-control" id="city" name="city_name" required="">                
                    </select>
                    </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Country</label>
                <div class="col-sm-12">
                <input type="hidden" name="country_id" id="country_id">
                <select class="form-control" id="country" name="country_name" required="" disabled>                
                    </select>                
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-update" value="create">Update
             </button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        
    </div>
</div>
</div>
</div>
</div>
</div>
</body>
</html>

<script>
   $(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('.edit-post').click(function(e) {
        e.preventDefault();  
        $('#postCrudModal').html("Edit post");
        $('#btn-save').val("edit-post");
        $('#ajax-crud-modal').modal('show');
        var hotelId = $(this).data('id');
        console.log("hotelId",hotelId);
        var countryId = $(this).closest('tr').find('.country-id').val();
        //var countryId = $("input[name='country_id']").val();
        console.log("country_id",countryId);
        $.ajax({
            url:'/get-hotel-data',
            type:'get',
            data: { hotelId,countryId },
            success:function(data) {
                console.log(data);
                console.log("data", data.data);
            var hotel = data.data;  
            // $.each(data.data, function(index, hotel)
            //     { 
                  console.log(hotel.hotel_name);
                  $('#hotel_id').val(hotel.hotel_id);
                  $('#hotel_name').val(hotel.hotel_name);
                  $('#desc').val(hotel.desc);
                  $('#city').val(hotel.city_name);

                $.each(data.city,function(index,city) {
                   // console.log(city);
                      $('#city').append($('<option>',{
                         value:city.id,
                         text:city.name,
                      }));
                });


                  $('#country').val(hotel.country_name);
                  $.each(data.countries,function(index,country) {
                      $('#country').append($('<option>',{
                            value:country.id,
                            text:country.name
                      }));
                  });

                  $('#city_id').val(hotel.city_id);
                  $('#country_id').val(hotel.country_id);

            //});                
          }
        });
        
    });

    $('#btn-update').click(function(e) {
        e.preventDefault();
        var edit_data = $('#hotelupdate').serialize();
        console.log("hotelupdate",edit_data);
        
        $.ajax({
            url:"/update-hotel",
            type:"post",
            data:edit_data,
            success:function(data) {
                console.log(data);
            }
        })


    });

    $('.delete-post').click(function(e) {
        e.preventDefault();
        var hotel_id = $(this).data('id');
        console.log(hotel_id);
        $.ajax({
            url:"/delete-hotel",
            type:'post',
            data: { hotel_id: hotel_id },            
            sucess:function(data){
                console.log(data);
            } 

        })
    })
});


</script>
