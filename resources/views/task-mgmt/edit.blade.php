@extends('task-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Update Notes</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('task-management.update', ['id' => $update_task->id]) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PATCH">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ $update_task->title }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->title('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                  
                        
                        <div class="form-group{{ $errors->has('task_detail') ? ' has-error' : '' }}">
                            <label for="text" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="task_detail" rows="5" type="text" class="form-control" name="task_detail"  required > {{ $update_task->task_detail }} </textarea>
                                
                                @if ($errors->has('task_detail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->task_detail('task_detail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                       
                           
                       
                       
                        <div class="form-group">
                            <label class="col-md-4 control-label">Department</label>
                            <div class="col-md-6">
                                <select class="form-control" name="department_id">
                                    @foreach ($departments as $department)
                                        <option {{$update_task->department_id == $department->id ? 'selected' : ''}} value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Division</label>
                            <div class="col-md-6">
                                <select class="form-control" name="division_id">
                                    @foreach ($divisions as $division)
                                        <option {{$update_task->division_id == $division->id ? 'selected' : ''}} value="{{$division->id}}">{{$division->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >Upoad File</label>
                            <div class="col-md-6">
                                
                                <input type="file" id="file" name="file" value="{{$update_task->file}}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

