@extends('layouts.index')
@section('content')

<div class="container">
<br>
<br>
<div class="row">
    <div class="col-md-12 centered">  
    <div class="col-md-8">
       <!--  <a href="{{ url('/add') }}" class="btn btn-primary btn-xs" title="Add New Post"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a> -->
        
        <form class="form-inline">
          <div class="form-group">
            <label name="">Person</label>
            <a href="{{ url('/add') }}"><button type="button" class="btn btn-primary">Primary</button></a>
          </div>
        </form>
    </div>
    <div class="col-md-2">
        <a class="inactive" id="inactive" href="#" target="">By City</a>
    </div>
    <div class="col-md-2">
        <a class="active" id="active" href="#" target="">By Department</a>
    </div>
    <table id="datas-list" name="datas-list">
        <thead>
            <tr>
                <th>Name</th>
                <th>City</th>
                <th>Email</th>
                <th>Department</th>
                <th>Avatar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr id="data{{ $data['id'] }}">
                <td>
                    {{ $data['name'] }}<br>
                    <small>{{ $data['position'] }}</small>
                </td>
                <td>{{ $data['city'] }}</td>
                <td>{{ $data['email'] }}</td>
                <td>{{ $data['department'] }}</td>
                <td><img src="{{ $data['avatar'] }}" height="60" alt="avatar"></td>
                <td>
                    @if ($data['status'] === '1')
                        <h4><p class="label label-success round">Masuk<p></h4>
                    @elseif ($data['status'] === '2')
                        <h4><p class="label label-danger round">Cuti<p></h4>
                    @else
                        <h4><p class="label label-default round">Libur<p></h4>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>
<br>
<br>
</div>

@endsection