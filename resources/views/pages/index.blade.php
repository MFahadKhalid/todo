@extends('layouts.scaffold')
@push('title')
{{ $title ?? '' }}
@endpush
@push('styles')
<style>
   .spinner-border {
   height: 20px;
   width: 20px;
   }
</style>
@endpush
@section('content')
<div class="mt-5 container">
   <div style="float: right;" class="">
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#CreateTodo">Create Task</button>
   </div>
   <div>
      <table class="table table-striped mt-5" id="datatable">
         <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
               <th>Image</th>
               <th>Description</th>
               <th>Task</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody class="PrintTodo">
            <tr class="todoLoader" style="display: none;">
                <td class="text-center" colspan="6">
                    <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                </td>
            </tr>
         </tbody>
      </table>
   </div>
</div>
{{-- Create Todo --}}
<div class="modal fade" id="CreateTodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <ul id="todoErrorList"></ul>
            <form method="POST" id="AddTodo" enctype="multipart/form-data" class="TodoValidate">
               <div class="todoModal">
                  <div class="row">

                <div class="col-md-12 mb-3">
                        <label for="">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control todo_title" name="title">
                        <small class="text-danger" id="titleErrors"></small>
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control todo_image" id="image">
                        <small class="text-danger" id="imageErrors"></small>
                    </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="15" rows="5"></textarea>
                        <small class="text-danger" id="descriptionErrors"></small>
                    </div>
                  </div>
               </div>
               <div style="float: right;">
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary me-sm-3 me-1">
                     <div style="display: none;" class="loader spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                     </div>
                     Create
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
{{-- Edit Todo --}}
<div class="modal fade" id="EditTodoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <ul id="EdittodoErrorList"></ul>
            <form method="POST" id="EditTodo">
               <input type="hidden" name="todo_id" id="todo_id">
               <div class="todoModal">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <label for="">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control edit_todo_title" name="title" id="edit_todo_title">
                        <small class="text-danger" id="EditTitleErrors"></small>
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Image </label>
                        <input type="file" name="image" class="form-control todo_image" id="image">
                        <span id="edit_todo_image"></span>
                        <small class="text-danger" id="EditimageErrors"></small>
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Description </label>
                        <textarea name="description" class="form-control" id="edit_todo_description" cols="15" rows="5"></textarea>
                        <small class="text-danger" id="EditdescriptionErrors"></small>
                     </div>
                  </div>
               </div>
               <div style="float: right;">
                  <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-warning text-light me-sm-3 me-1">
                     <div style="display: none;" class="loader spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                     </div>
                     Update
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
{{-- Delete Todo --}}
<div class="modal fade" id="DeleteTodo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete Task</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <input type="hidden" id="delete_todo_id">
            <div>
               <h5>Are you sure you want to delete this data?</h5>
            </div>
         </div>
         <div class="modal-footer">
            <div class="" style="float: right;">
               <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
               <button type="submit" class="btn btn-danger me-sm-3 me-1 delete_todo">
                  <div style="display: none;" class="loader spinner-border" role="status">
                     <span class="sr-only">Loading...</span>
                  </div>
                  Delete
               </button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<script>


   $(document).ready(function (){
       $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       });
       fetchTodo();
       function fetchTodo(){

            $.ajax({
                type: "GET",
                url: "{{ route('todo.fetch') }}",
                dataType: 'json',
                beforeSend: function(res){
                    $('.todoLoader').show();
                },
                success: function(res){
                    $('.todoLoader').hide();
                    $('.PrintTodo').html("");
                    $.each(res.todo , function(key,item){
                        var append = "<tr class='post'>"+
                            "<td>"+ ++key +"</td>"+
                            "<td>"+item.title+"</td>"+
                            "<td>"+
                            (""+item.image+"" != 0 ? "<img class='img-thumbnail' src='storage/upload/todo/"+item.image+"' width='100px' alt="+item.image+">" : "<img class='img-thumbnail' src='assets/img/no-image-icon-6.png' width='50px' alt='no-image-icon-6.png'>")+
                            "</td>"+
                            "<td>"+item.description+"</td>"+
                            "<td>"+
                            (""+item.status+"" == 1 ? "<button style='border: none; margin-right: 4px;' id='completed' class='badge bg-success'>Completed</button>" : "<div class='markAsComplete"+item.id+"'><button style='border: none; margin-right: 4px;' class='badge bg-default'><div style='display: none; height: 14px; width: 13px;' class='task_loader"+item.id+" spinner-border text-success' role='status'><span class='sr-only'>Loading...</span></div><a id='' class='text-dark' style='text-decoration: none;' onClick='TaskDone($(this),"+item.id+")' href='javascript:;'>Mark as Completed</a></button></div>")+
                            "</td>"+
                            "<td><button style='border: none; margin-right: 4px;' value="+item.id+" class='edit_todo_btn badge bg-warning'>"+
                            "<div style='display: none; height: 14px; width: 13px;' class='Edit_loader"+item.id+" spinner-border' role='status'>"+
                            "<span class='sr-only'>Loading...</span>"+
                            "</div>"+
                            "Edit"+
                            "</button>"+
                            "<button style='border: none; margin-right: 4px;' value="+item.id+" class='delete_todo_btn badge bg-danger'>"+
                            "<div style='display: none; height: 14px; width: 13px;' class='delete_loader"+item.id+" spinner-border' role='status'>"+
                            "<span class='sr-only'>Loading...</span>"+
                            "</div>"+
                            "Delete"+
                            "</button>"+
                            "</td>";
                        $(".PrintTodo").append(append);
                    });
                }
               });
            }
               $(document).on('submit' ,'#AddTodo', function(e){
          e.preventDefault();
          let formData = new FormData($('#AddTodo')[0]);
          $.ajax({
               type: "POST",
               url: "{{ route('todo.store') }}",
               data: formData,
               contentType: false,
               processData: false,
               beforeSend : function(response){
                   $('.loader').show();
               },
               success: function(res){
                       $('.loader').hide();
                       $('#titleErrors').html("");
                       $('#imageErrors').html("");
                       $('#descriptionErrors').html("");
                       $('#AddTodo').find('input').val('');
                       $('#AddTodo').find('textarea').val('');
                       $('#CreateTodo').modal('hide');
                        fetchTodo();
                       toastr.success(res.message);
               },
               error: function(res){
                $('.loader').hide();
                var formErrors = res.responseJSON.errors;
                    if(formErrors.hasOwnProperty('title')){
                        str = formErrors.title[0];
                        $('#titleErrors').html(str);
                    }
                    if(formErrors.hasOwnProperty('image')){
                        str = formErrors.image[0];
                        $('#imageErrors').html(str);
                    }
                    if(formErrors.hasOwnProperty('description')){
                        str = formErrors.description[0];
                        $('#descriptionErrors').html(str);
                    }
               }
          });
       $(document).on('click' , '.edit_todo_btn' , function(e){
          e.preventDefault();
           var todo_id = $(this).val();
           $('#EditTodoModal').modal('show');
           $.ajax({
               type: "GET",
               url: "todo/edit/"+todo_id,
               beforeSend : function(response){
                   $('.Edit_loader'+todo_id+'').show();
               },
               success:function (res){
                   if(res.status == 404){
                       $('.Edit_loader'+todo_id+'').hide();
                       toastr.error(res.message);
                       $('#EditTodoModal').modal('hide');
                   }else{
                       $('.Edit_loader'+todo_id+'').hide();
                       $('#edit_todo_title').val(res.todo.title);
                      $('#edit_todo_description').val(res.todo.description);
                      $('#edit_todo_image').html(""+res.todo.image+"" != 0 ? "<img class='img-thumbnail' src='storage/upload/todo/"+res.todo.image+"' width='100px' alt="+res.todo.image+">" : "<img class='img-thumbnail' src='assets/img/no-image-icon-6.png' width='50px' alt='no-image-icon-6.png'>");
                       $('#todo_id').val(todo_id);
                   }
               },

           })
       });
       $(document).on('submit' , '#EditTodo' , function(e){
          e.preventDefault();
           var todo_id = $('#todo_id').val();
           let EditformData = new FormData($('#EditTodo')[0]);
           $.ajax({
               type: "POST",
               url: "todo/update/"+todo_id,
               data: EditformData,
               contentType: false,
               processData: false,
               beforeSend : function(res){
                   $('.loader').show();
               },
               success: function(res){
                if(res.status == 200){
                       $('.loader').hide();
                       $('#EditTitleErrors').html("");
                       $('#EditimageErrors').html("");
                       $('#EditdescriptionErrors').html("");
                       $('#EditTodo').find('input').val('');
                       $('#EditTodo').find('textarea').val('');
                       toastr.success(res.message);
                       $('#EditTodoModal').modal('hide');
                        fetchTodo();
                   }else if(res.status == 404){
                       $('#EditTodoModal').modal('hide');
                       $('.loader').hide();
                       toastr.error(res.message);
                   }
               },
               error: function(res){
                $('.loader').hide();
                var formErrors = res.responseJSON.errors;
                    if(formErrors.hasOwnProperty('title')){
                        str = formErrors.title[0];
                        $('#EditTitleErrors').html(str);
                    }
                    if(formErrors.hasOwnProperty('image')){
                        str = formErrors.image[0];
                        $('#EditimageErrors').html(str);
                    }
                    if(formErrors.hasOwnProperty('description')){
                        str = formErrors.description[0];
                        $('#EditdescriptionErrors').html(str);
                    }
               }
           })
       });
       $(document).on('click' , '.delete_todo_btn' , function (e){
          e.preventDefault();
           var todo_id = $(this).val();
           $('#DeleteTodo').modal('show');
           $('#delete_todo_id').val(todo_id);
       });
       $(document).on('click' , '.delete_todo' , function (e){
          e.preventDefault();
          var id = $('#delete_todo_id').val();
           $.ajax({
               type: "DELETE",
               url: "todo/delete/"+id,
               dataType: 'json',
               beforeSend : function(res){
                   $('.loader').show();
               },
               success: function(res){
                   if(res.status == 404){
                       $('.loader').hide();
                       toastr.error('404 not found');
                       $('#DeleteTodo').modal('hide');
                   }else if(res.status == 200){
                       $('.loader').hide();
                       $('#DeleteTodo').modal('hide');
                       toastr.success(res.message);
                        fetchTodo();
                   }
               }
           })
       });
    })
   })



   function TaskDone(elm,id){

           $.ajax({
               type: 'POST',
               url: 'todo/task/completed/'+id,
               data: {
                   '_token' : "{{csrf_token()}}",
               },
               beforeSend : function(res){
                   $('.task_loader'+id+'').show();
               },
               success: function(res){
                   if(res.status == 404){
                       $('.task_loader'+id+'').hide();
                       toastr.error(res.message);
                    }else{
                       $('.markAsComplete'+id+'').html("<button style='border: none; margin-right: 4px;' id='completed' class='badge bg-success'>Completed</button>");
                        $('.task_loader'+id+'').hide();
                        toastr.success(res.message);
                    }
                }
            });
        }



    </script>



@endpush
