@extends('layouts.index')
@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <br>
      <br>
      <div class="panel panel-primary">
        <div class="panel-heading">Create New Data</div>
        <div class="panel-body a1">
          <form action="{{ url('store') }}" method="POST" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" name="name">
              </div>

              <div class="form-group">
                  <label for="position">Position</label>
                  <input type="text" class="form-control" name="position">
              </div>

              <div class="form-group">
                  <label for="city">City</label>
                  <input type="text" class="form-control" name="city">
              </div>

              <div class="form-group">
                  <label for="email">Email</label>
                  <input type="text" class="form-control" name="email">
              </div>

              <div class="form-group">
                  <label for="department">Department</label>
                  <input type="text" class="form-control" name="department">
              </div>

              <div class="form-group">
                  <label for="avatar">Avatar</label>
                  <input type="file" name="avatar">
              </div>
              
              <div class="form-group">
                  <label for="status">Status</label>
                  <select class="form-control" name="status">
                    <option value="1">Masuk</option>
                    <option value="2">Cuti</option>
                    <option value="3">Libur</option>
                  </select>
              </div>

              <button type="submit" class="btn btn-default">Submit</button>
          </form>
          </div>
      </div>
    </div>
  </div>
</div>

@endsection
