@extends('layouts.index')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <br>
      <br>
      <div class="panel panel-default">
        <div class="panel-heading">Edit Post: {{ $row['id'] }}</div>
        <div class="panel-body">
          <form action="{{ url('update', $row['id']) }}" method="POST" enctype="multipart/form-data">
             {!! method_field('put') !!}
             {!! csrf_field() !!}        
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" value="{{ $row['name'] }}" class="form-control" name="name">
              </div>

              <div class="form-group">
                  <label for="position">Position</label>
                  <input type="text" value="{{ $row['position'] }}" class="form-control" name="position">
              </div>

              <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" value="{{ $row['city'] }} "class="form-control" name="city">
              </div>

              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" value="{{ $row['email'] }}" class="form-control" name="email">
              </div>

              <div class="form-group">
                  <label for="department">Department</label>
                  <input type="text" value="{{ $row['department'] }}" class="form-control" name="department">
              </div>

              <div class="form-group">
                  <label for="avatar">Avatar</label>
                  <input type="file" name="avatar">
              </div>
              
              <div class="form-group">
                  <label selected="{{ $row['status'] }}" for="status">Status</label>
                  <select class="form-control" name="status">
                    <option value="1"{{ $row['status'] == '1' ? 'selected="selected"' : '' }}>Masuk</option>
                    <option value="2"{{ $row['status'] == '2' ? 'selected="selected"' : '' }}>Cuti</option>
                    <option value="3"{{ $row['status'] == '3' ? 'selected="selected"' : '' }}>Libur</option>
                  </select>
              </div>                   

            <button type="submit" class="btn btn-default">Update</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

@endsection
