@extends('system-mgmt.semester.base')

@section('action-content')
<div class="container">
    <div class="row">
          <div class="col-md-10" align="right">
          <a class="btn btn-primary" href="{{route ('semester.index')}}">Back</a>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Add Semester</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ route('semester.store') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Semester Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Department Name</label>
                            <div class="col-md-6">
                                <select class="form-control" name="department_id">
                                    @foreach ($department as $departments)
                                        <option value="{{$departments->id}}">{{$departments->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
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
