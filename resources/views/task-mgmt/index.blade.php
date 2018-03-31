@extends('task-mgmt.base')
@section('action-content')
    <!-- Main content -->
    <section class="content">
      <div class="box">
  <div class="box-header">
    <div class="row">
        <div class="col-sm-8">
          <h3 class="box-title">List of Notes</h3>
        </div>
        <div class="col-sm-4">
          <a class="btn btn-primary" href="{{ route('task-management.create') }}">ADD NOTES</a>
        </div>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <div class="row">
        <div class="col-sm-6"></div>
        <div class="col-sm-6"></div>
      </div>
      <form method="POST" action="{{ route('task-management.search') }}">
         {{ csrf_field() }}
         @component('layouts.search', ['title' => 'Search'])
          @component('layouts.two-cols-search-row', ['items' => ['Department', 'Subject'], 
          'oldVals' => [isset($searchingVals) ? $searchingVals['department_name'] : '', isset($searchingVals) ? $searchingVals['title'] : '']])
          @endcomponent
          </br>
         
        @endcomponent
      </form>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
      <div class="row">
        <div class="col-sm-12">
          <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th text-center width="10%" class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Name: activate to sort column descending" aria-sort="ascending">Title</th>
                <th text-center width="20%" class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Description</th>
                <th text-center width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Department</th>
                <th text-center width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Batch</th>
                 <th text-center width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Semester</th>
                <th text-center width="20%" class="sorting hidden-xs" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Email: activate to sort column ascending">Notes</th>
<!--                <th tabindex="0" aria-controls="example2" rowspan="1" colspan="2" aria-label="Action: activate to sort column ascending">Notes</th>-->
                <th tabindex="0" width="30%" aria-controls="example2" rowspan="1"  aria-label="Action: activate to sort column ascending">Action</th>
<!--                <th tabindex="0" aria-controls="example2" rowspan="1"  aria-label="Action: activate to sort column ascending">Download </th>-->
              </tr>
            </thead>
            <tbody>
          
                 @foreach ($notes as $note)
                <tr role="row" class="odd">
                 
                  <td class="sorting_1">{{ $note->title }} </td>
                  <td class="hidden-xs">{{ $note->task_detail }}</td>
                  <td class="hidden-xs">{{ $note->department_name }}</td>
                  <td class="hidden-xs">{{ $note->division_name }}</td>
                  <td class="hidden-xs">{{ $note->division_name }}</td>
                  <td class="hidden-xs"><a>{{ $note->file }}</a></td>
                  <td> <form class="row" method="POST" action="{{ route('task-management.destroy', ['id' => $note->id]) }}" onsubmit = "return confirm('Are you sure?')">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <a class="btn btn-raised btn-primary" style="background-color:#e08e0b;" href="{{ route('task-management.edit', ['id' => $note->id]) }}" >
                            <i class="fa fa-pencil-square-o"  aria-hidden="true"></i>
                        </a>
                        <button class="btn btn-raised btn-danger "><i class="fa fa-trash "  aria-hidden="true"></i>
                        </button>
                    
                    </a>
                    </form>
                  </td>
                  <td> 
                      
                      <a href="../storage/app/public/download/{{ $note->file }}" download="{{ $note->file }}"><i class="fa fa-download" style="font-size:35px;color:#e08e0b" aria-hidden="true"></i>
                    </a>
                    
                  </td>
              </tr>
            @endforeach
            </tbody>
          
          </table>
        </div>
      </div>
            <div class="row">
        <div class="col-sm-5">
          <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to {{count($notes)}} of {{count($notes)}} entries</div>
        </div>
        <div class="col-sm-7">
          <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
            {{ $notes->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.box-body -->
</div>
    </section>
    <!-- /.content -->
  
@endsection
