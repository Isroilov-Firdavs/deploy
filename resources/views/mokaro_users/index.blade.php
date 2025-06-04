<!-- resources/views/mokaro_users/index.blade.php -->
@extends('layouts.app')

@section('title', 'Mokaro Users List')

@section('content')
    <h2>Mokaro Userlar ro‘yxati</h2>
  <table class="table">
    <thead class="table-success">
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>IP adress</th>
      </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->first_name}}</td>
                <td>{{$user->last_name}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->ip_address}}</td>
            </tr>
        @endforeach
    </tbody>
  </table>
    <!-- Paginate linklari -->
        <div class="d-flex justify-content-center">
            {!! $users->links() !!}
        </div>
@endsection
