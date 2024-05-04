<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <style>
        .custom-border {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Room Type</h1>
        <div class="row">
            <div class="col-6 offset-3">
                <form id="roomTypeForm" class="custom-border">
                    <div class="form-group mb-3">
                        <label for="size" class="form-label">Room size</label>
                        <input type="text" id="size" name="size" placeholder="Room Size" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" id="price" name="price" placeholder="Price" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" name="amount" placeholder="Amount" class="form-control">
                    </div>
                    <button id="save_room" action='save_room' class="btn btn-success room_crud">Add Room</button>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
              <table id="roomtype" class="table table-bordered">
                   <thead>
                      <tr>
                        <th>ID</th>
                        <th>Room Size</th>
                        <th>Room Price</th>
                        <th>Room Amount</th>
                        <th>Action</th>
                        
                      </tr>
                   </thead>
                   <tbody>
                       
                   </tbody>
              </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
   $(document).ready(function() {

// Fetch room types when the page loads
fetchRoomTypes();

// Function to fetch room types via AJAX
function fetchRoomTypes() {
    $.ajax({
        url: "{{ route('get_room_type') }}",
        type: 'GET',
        success: function(response) {
            console.log(response);
            if (response.code == 200) {
                $.each(response.room_types, function(index, roomType) {
                    var editButton = '<button class="editBtn crud" action="edit-room" data-id="' + roomType.id + '">Edit</button>';
                    var deleteButton = '<button class="dltBtn room_crud" action ="delete-room" data-id="' + roomType.id + '">Delete</button>';
                    $("#roomtype").append(
                        '<tr>' +
                        '<td>' + roomType.id + '</td>' +
                        '<td>' + roomType.size + '</td>' +
                        '<td>' + roomType.price + '</td>' +
                        '<td>' + roomType.amount + '</td>' +
                        '<td>' + editButton + ' ' + deleteButton + '</td>' +
                        '</tr>'
                    );
                });
                // Attach event listeners after appending buttons
                attachButtonListeners();
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        }
    });
}


// Function to attach event listeners to edit and delete buttons
function attachButtonListeners() {
      
    $('.room_crud').click(function() {
    
    var action = $(this).attr('action');
     console.log("action",action);
    var room_id = $(this).attr('data-id');
    console.log(" action", action);
    console.log("room_id",room_id);
    if(action === 'delete-room') {
        var requestData = {
                action: action,
                room_id: room_id
            };
        roomTypeCrud(action,requestData);     
    }
    $('#save_room').click(function() {
      action=   $($this).action('action');
    if(action === 'save_room') {
        console.log("save_room");
        requestData =  $("#roomTypeForm").serialize();
        var requestData = {
                action: action,
                requestData: requestData
            };
      console.log("requestData",requestData);
        roomTypeCrud(action,requestData);
    }
  });
    
   
});
}

// Function to handle CRUD operations
function roomTypeCrud(action,requestData) {
    console.log("in",action);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "/save-room-type",
        type: "post",
        //data: $("#roomTypeForm").serialize(),
        data:requestData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            $('#roomTypeForm')[0].reset();
            // Fetch and update room types after saving
            fetchRoomTypes();
            console.log(response);
        }
    });
}

// Handle click event for adding a room type


});

    
    // var table = $('#roomtype').DataTable({
    //     ajax: "{{ route('add_room_type') }}",
    //     columns: [
    //         { "data": "room_size" },
    //         { "data": "room_price" },
    //         { "data": "room_amount" },
    //         {
    //             "data":null,
    //             render:function(data,row,type) {
    //                 if(row.status == "Active") {
    //                     return '<button class="btn btn success">Edit</button>';
    //                 }
    //                 else {
    //                     return '<button class="btn btn success">Delete</button>';

    //                 }
    //             }
    //         }
    //     ]
    // });


    </script>
</body>
</html>
