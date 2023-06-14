@extends('layouts.app')
   
@section('content')
   <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
               <div class="card rounded-3">
                  <div class="card-body p-4 text-center">
                    <p class="fs-1">Hello {{ Auth::user()->name }}!</p><br>
                    <a href="{{route('todo.index')}}" class="btn btn-primary btn-lg">Go to Todo lists</a><br><br>
                    <a href="{{route('todo.send')}}" class="btn btn-primary btn-lg">Send my Todo lists</a>
                  </div>
               </div>
            </div>
         </div>
   </div>
@endsection

