@extends('layouts.default')
@section('title','用户列表')
@section('content')
<div class="offset-md-2 col-md-8">
    <h2 class="mb-4 text-center">所有用户</h2>
    <div class="list-group list-group-flush">
        @foreach($userAll as $user)
        @include('users._user')
        @endforeach
    </div>
    <div class="mt-3">
        {!! $userAll->render() !!}
        
    </div>
</div>
@stop