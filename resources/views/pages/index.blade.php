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
   {{--
   <div class="mt-5"></div>
   --}}
   <div id="printTodo" >
      <table class="table table-striped mt-5">
         <thead>
            <tr>
               <th>ID</th>
               <th>Title</th>
               <th>Image</th>
               <th>Description</th>
               <th>Task</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            @forelse ($todos as $index=>$todo)
            <tr>
               <td>{{ ++$index }}</td>
               <td>{{ $todo->title }}</td>
               <td>
                  @if (!empty($todo->image))
                  <img class="img-thumbnail" src="{{ asset('upload/todo/'.$todo->image) }}" width="100px" alt="{{ $todo->image }}">
                  @else
                  <img class="img-thumbnail" src="{{ asset('assets/img/no-image-icon-6.png') }}" width="50px" alt="no-image-icon-6.png">
                  @endif
               </td>
               <td>{{ $todo->description }}</td>
               <td>
                  @if ($todo->status == 1)
                  <button style="border: none; margin-right: 4px;" class="badge bg-success">Completed</button>
                  @else
                  <button style="border: none; margin-right: 4px;" class="badge bg-default">
                     <div style="display: none; height: 14px; width: 13px;" class="task_loader{{ $todo->id }} spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                     </div>
                     <a class="text-dark" style="text-decoration: none;" onClick="TaskDone($(this),{{$todo->id}})" href="javascript:;">Mark as Completed</a>
                  </button>
                  @endif
               </td>
               <td>
                  <button style="border: none; margin-right: 4px;" value="{{ $todo->id }}" class="edit_todo_btn badge bg-warning">
                     <div style="display: none; height: 14px; width: 13px;" class="Edit_loader{{ $todo->id }} spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                     </div>
                     Edit
                  </button>
                  <button style="border: none; margin-right: 4px;" value="{{ $todo->id }}" class="delete_todo_btn badge bg-danger">
                     <div style="display: none; height: 14px; width: 13px;" class="delete_loader{{ $todo->id }} spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                     </div>
                     Delete
                  </button>
               </td>
            </tr>
            @empty
            <td class="text-center" colspan="6">No record found</td>
            @endforelse
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
            <form method="POST" id="AddTodo" enctype="multipart/form-data">
               <div class="todoModal">
                  <div class="row">
                     <div class="col-md-12 mb-3">
                        <label for="">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control todo_title" name="title">
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Image</label>
                        <input type="file" name="image" class="form-control todo_image" id="image">
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="15" rows="5"></textarea>
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
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Image </label>
                        <input type="file" name="image" class="form-control todo_image" id="image">
                        <span id="edit_todo_image"></span>
                     </div>
                     <div class="col-md-12 mb-3">
                        <label for="">Description </label>
                        <textarea name="description" class="form-control" id="edit_todo_description" cols="15" rows="5"></textarea>
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
<script>
   function routeToTodo(elm){
       $.ajax({
           url: "{{ route('todo') }}",
           type: "GET",
           data: {},
           success: function (res){
               $('#printTodo').html(res.data);
           },
           error : function(res){
               toastr.error('Something went wrong');
           }
       })
   }

   $(document).ready(function (){
       $.ajaxSetup({
           headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
       });
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
                   if(res.status == 400){
                       $('.loader').hide();
                       $('#todoErrorList').html("");
                       $('#todoErrorList').addClass("alert alert-danger d-none");
                       $('#todoErrorList').removeClass("d-none");
                       $.each(res.errors , function(key,err_value){
                           $('#todoErrorList').append('<li>'+err_value+'</li>');
                       });
                   }else if(res.status == 200){
                       $('.loader').hide();
                       $('#AddTodo').find('input').val('');
                       $('#AddTodo').find('textarea').val('');
                       $('#todoErrorList').hide("alert alert-danger d-none");
                       $('#CreateTodo').modal('hide');
                       routeToTodo();
                       toastr.success(res.message);
                   }
               }
          })
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
                      $('#edit_todo_image').html("<img src='upload/todo/"+res.todo.image+"' width='100' class='mt-3 img-thumbnail' alt="+res.todo.image+">");
                       $('#todo_id').val(todo_id);
                   }
               }
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
                   if(res.status == 400){
                       $('.loader').hide();
                       $('#EdittodoErrorList').html("");
                      $('#EdittodoErrorList').addClass("alert alert-danger d-none");
                      $('#EdittodoErrorList').removeClass("d-none");
                      $.each(res.errors , function(key,err_value) {
                          $('#EdittodoErrorList').append('<li>'+err_value+'</li>');
                      });
                   }else if(res.status == 200){
                       $('.loader').hide();
                       toastr.success(res.message);
                       $('#EditTodoModal').modal('hide');
                       $('#EdittodoErrorList').hide("alert alert-danger d-none");
                       routeToTodo();
                   }else if(res.status == 404){
                       $('#EditTodoModal').modal('hide');
                       $('.loader').hide();
                       toastr.error(res.message);
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
                       routeToTodo();
                   }
               }
           })
       });
   })



   function TaskDone(elm,id){
           $.ajax({
               type: 'POST',
               url: 'task/completed/'+id,
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
                       $('.task_loader'+id+'').hide();
                       routeToTodo();
                       toastr.success(res.message);
                   }
               }
           });
       }
</script>
@endpush
