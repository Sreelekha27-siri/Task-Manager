@extends('layout.baseview')
@section('title','All Tasks')
@section('style')
<style>
    .done{
        text-decoration: line-through
    }
</style>
@endsection
@section('content')
    @include('layout.navigation')
    <div class="container mt-5">
       <button type="button" class="btn btn-outline-primary mb-5 end-0" onclick="addtask()">Add Tasks</button>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                           <th scope="col">Si No.</th>
                           <th scope="col">Task Description</th>
                           <th scope="col">Task Owner</th>
                           <th scope="col">Task ETA</th>
                           <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskTable">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">Add Task</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="createTaskDescription" placeholder="Enter Task Description">
                        </div>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Owner</label>
                            <input type="text" class="form-control" id="createTaskOwner" placeholder="Enter Task Owner">
                        </div>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Owner Email</label>
                            <input type="text" class="form-control" id="createTaskEmail" placeholder="Enter Task Owner Email">
                        </div>
                        <div class="form-group">
                            <label for="createTaskDescription">Task ETA</label>
                            <input type="date" class="form-control" id="createTaskETA" placeholder="Enter Task ETA">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="createTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">Add Task</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="editTaskDescription" placeholder="Enter Task Description">
                        </div>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Owner</label>
                            <input type="text" class="form-control" id="editTaskOwner" placeholder="Enter Task Owner">
                        </div>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Owner Email</label>
                            <input type="text" class="form-control" id="editTaskEmail" placeholder="Enter Task Owner Email">
                        </div>
                        <div class="form-group">
                            <label for="editTaskDescription">Task ETA</label>
                            <input type="date" class="form-control" id="editTaskETA" placeholder="Enter Task ETA">
                        </div>
                        <div class="form-group">
                            <label for="editTaskStatus">Task Status</label>
                            <select class="form-control" id="editTaskStatus">
                               <option>Set Task Status</option>
                               <option value="0">In Progress</option>
                               <option value="1">Done</option>
                            </select>
                            </select>
                        </div>
                        <input type="hidden" id="editTaskid">

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doneTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">Mark Task as Done</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Mark this Task as Done?</p> 
                    <input type="hidden" id="doneTaskid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateMarkAsDone()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title">Delete Task</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to Delete this Task?</p> 
                    <input type="hidden" id="deleteTaskid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateTaskDelete()">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        getAllTasks();
    })
    function getAllTasks(){
        $.ajax({
            type:'get',
            url:'http://localhost:8000/api/task',
            success:function(result){
                var html ='';
                for(var i=0;i<result.length;i++){
                   var lineThrough = result[i]['status'] == 1? 'class="done"' : "";
                   html += '<tr>'
                           +'<th scope="row" '+lineThrough+'>'+(i+1)+'</th>'
                           +'<td '+lineThrough+'>'+result[i]['task_description']+'</td>'
                           +'<td '+lineThrough+'>'+result[i]['task_owner']+'</td>'
                           +'<td '+lineThrough+'>'+result[i]['task_eta']+'</td>'
                           +'<td>'
                              +'<i class="bi bi-pencil-square" onclick="editTask('+result[i]['id']+')"></i>'
                              +'<i class="bi bi-check2-square" onclick="markasdone('+result[i]['id']+')"></i>'
                              +'<i class="bi bi-trash" onclick="deleteTask('+result[i]['id']+')"></i>'
                              +'</td>'
                              +'</tr>'
                }
                $("#taskTable").html(html)
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
    function addtask(){
        $("#createTaskModal").modal('show');
    }
    function createTask(){
        var task_description = $("#createTaskDescription").val()
        var task_owner = $("#createTaskOwner").val()
        var task_owner_email = $("#createTaskEmail").val()
        var task_eta = $("#createTaskETA").val()
        $.ajax({
            type:'post',
            url:'http://localhost:8000/api/task',
            data:{
                task_description:task_description,
                task_owner:task_owner,
                task_owner_email:task_owner_email,
                task_eta:task_eta
            },
            success:function(result){
                $("#createTaskModal").modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
    function editTask(id){
         $.ajax({
            type:'get',
            url:'http://localhost:8000/api/task/'+id,
            success:function(result){
                $("#editTaskDescription").val(result['task_description']);
                $("#editTaskOwner").val(result['task_owner']);
                $("#editTaskEmail").val(result['task_owner_email']);
                $("#editTaskETA").val(result['task_eta']);
                $("#editTaskStatus").val(result['status']);
                $("#editTaskid").val(result['id']);
                $("#editTaskModal").modal('show');
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
    function updateTask(){
        var id = $("#editTaskid").val();
        var task_description = $("#editTaskDescription").val()
        var task_owner = $("#editTaskOwner").val()
        var task_owner_email = $("#editTaskEmail").val()
        var task_eta = $("#editTaskETA").val()
        var task_status = $("#editTaskStatus").val()
        $.ajax({
            type:'put',
            url:'http://localhost:8000/api/task/'+id,
            data:{
                task_description:task_description,
                task_owner:task_owner,
                task_owner_email:task_owner_email,
                task_eta:task_eta,
                task_status:task_status
            },
            success:function(result){
                $("#editTaskModal").modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
    function markasdone(id){
        $("#doneTaskid").val(id)
        $("#doneTaskModal").modal('show')
    }
    
    function updateMarkAsDone(){
        var id = $("#doneTaskid").val();
        $.ajax({
            type:'post',
            url:'http://localhost:8000/api/task/done/'+id,
            success:function(result){
                $("#doneTaskModal").modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
     function deleteTask(id){
        $("#deleteTaskid").val(id)
        $("#deleteTaskModal").modal('show')
    }
    
    function updateTaskDelete(){
        var id = $("#deleteTaskid").val();
        $.ajax({
            type:'delete',
            url:'http://localhost:8000/api/task/'+id,
            success:function(result){
                $("#deleteTaskModal").modal('hide');
                getAllTasks();
            },
            error:function(e){
                console.log(e.responseText)
            }
        })
    }
</script>
@endsection