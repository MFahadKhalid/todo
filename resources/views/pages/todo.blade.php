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
                  <button style="border: none; margin-right: 4px;" class="badge bg-default"><div style="display: none; height: 14px; width: 13px;" class="task_loader{{ $todo->id }} spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                  </div><a class="text-dark" style="text-decoration: none;" onClick="TaskDone($(this),{{$todo->id}})" href="javascript:;">Mark as Completed</a></button>
                  @endif
                </td>
                <td>
                    <button style="border: none; margin-right: 4px;" value="{{ $todo->id }}" class="edit_todo_btn badge bg-warning"><div style="display: none; height: 14px; width: 13px;" class="Edit_loader{{ $todo->id }} spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div> Edit</button>
                      <button style="border: none; margin-right: 4px;" value="{{ $todo->id }}" class="delete_todo_btn badge bg-danger"><div style="display: none; height: 14px; width: 13px;" class="delete_loader{{ $todo->id }} spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>Delete</button>
                </td>
            </tr>
            @empty
            <td class="text-center" colspan="6">No record found</td>

        @endforelse
    </tbody>
  </table>
