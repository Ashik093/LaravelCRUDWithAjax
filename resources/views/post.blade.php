<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Ajax Crud</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<body>

	<div class="container">
		<br><br>
		<a onclick="addForm()" href="#" class="btn btn-default btn-sm btn-primary text-white" style="float: right;">Add New Post</a><br><br>
		<table class="table table-striped" id="post-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Title</th>
					<th>Author</th>
					<th>Details</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
		</table>
	</div>

	@include('form')
	
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

	<script>
		var table1=$('#post-table').DataTable({
			processing: true,
			serverSide:true,
			ajax:"{{ route('all.post') }}",
			columns:[
				{data:'id',name:'id'},
				{data:'title',name:'title'},
				{data:'author',name:'author'},
				{data:'details',name:'details'},
				{data:'action',name:'action',orderable:false,searchable:false}
			]
		});

		function addForm(){
			save_method="add";
			$('input[name=_method]').val('POST');
			$('#modal-form').modal('show');
			$('#modal-form form')[0].reset();
			$('.modal-title').text('Add Post');
			$('#insertbutton').text('Add Post');
		}
		//Insert data by Ajax
		$(function(){
		    $('#modal-form form').on('submit', function (e) {
		    if (!e.isDefaultPrevented()){
		        var id = $('#id').val();
		        if (save_method == 'add') url = "{{ url('post') }}";
		        else url = "{{ url('post') . '/' }}" + id;
		        $.ajax({
		            url : url,
		            type : "POST",
		            data: new FormData($("#modal-form form")[0]),
		            contentType: false,
		            processData: false,
		            success : function(data) {
		                		$('#modal-form').modal('hide');
		                    	table1.ajax.reload();
		                        swal({
		                            title: "Good job!",
		                            text: "Data inserted successfully!",
		                            icon: "success",
		                            button: "Great!",
		                            });
		                        },
		            error : function(data){
		                        swal({
		                            title: 'Oops...',
		                            text: data.message,
		                            type: 'error',
		                            timer: '1500'
		                            })
		                        }
		            });
		        	return false;
		    	}
			});
		});

		//edit ajax request are here
         function editForm(id) {
         save_method = 'edit';
          $('input[name=_method]').val('PATCH');
          $('#modal-form form')[0].reset();
          $.ajax({
            url: "{{ url('post') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              $('#modal-form').modal('show');
              $('.modal-title').text('Edit Post');
              $('#insertbutton').text('Update Post');
              $('#id').val(data.id);
              $('#title').val(data.title);
              $('#author').val(data.author);
              $('#details').val(data.details);
            },
            error : function() {
                alert("Nothing Data");
            }
          });
        }

        //show single data ajax part here
        function showData(id) {
           $.ajax({
               url: "{{ url('post') }}" + '/' + id,
               type: "GET",
               dataType: "JSON",
             success: function(data) {
               $('#single-data').modal('show');
               $('.modal-title').text('Details');
               $('#contactid').text(data.id); 
               $('#fullname').text(data.title);
               $('#contactemail').text(data.author);
               $('#contactnumber').text(data.details);
             },
             error : function() {
                 alert("Ghorar DIm");
             }
           });
         }

        function deleteData(id){
                  var csrf_token = $('meta[name="csrf-token"]').attr('content');
                  swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                  })
                  .then((willDelete) => {
                    if (willDelete) {
                      $.ajax({
                          url : "{{ url('post') }}" + '/' + id,
                          type : "POST",
                          data : {'_method' : 'DELETE', '_token' : csrf_token},
                          success : function(data) {
                              table1.ajax.reload();
                              swal({
                                title: "Delete Done!",
                                text: "You clicked the button!",
                                icon: "success",
                                button: "Done",
                              });
                          },
                          error : function () {
                              swal({
                                  title: 'Oops...',
                                  text: data.message,
                                  type: 'error',
                                  timer: '1500'
                              })
                          }
                      });
                    } else {
                      swal("Your imaginary file is safe!");
                    }
                  });
                } 
	</script>
</body>
</html>