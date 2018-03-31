@extends('task-mgmt.base')

@section('action-content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Upload Notes</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('task-management.store') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        <div class="form-group{{ $errors->has('task_detail') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="task_detail" rows="5" type="text" class="form-control" name="task_detail" value="{{ old('task_detail') }}" required></textarea>

                                @if ($errors->has('task_detail'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('task_detail') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      
                        <div class="form-group{{ $errors->has('department_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Department</label>
                            <div class="col-md-6">
                                <select class="form-control" name="department_id">
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}">{{$department->name}}</option>
                                    @endforeach
                                </select>
                                 @if ($errors->has('department_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('department_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('division_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Batch</label>
                            <div class="col-md-6">
                                <select class="form-control" name="division_id">
                                    @foreach ($divisions as $division)
                                        <option value="{{$division->id}}">{{$division->name}}</option>
                                    @endforeach
                                </select>
                                 @if ($errors->has('division_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('division_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="avatar" class="col-md-4 control-label" >Upload File</label>
                            <div class="col-md-6">
                                <input type="file" id="file" name="file" required >
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" onclick="{{ route('task-management.store') }}">
                                    Upload Notes
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


