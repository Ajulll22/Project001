@extends('layouts.master')

@section('title', "Dashboard")

@section('page-script')
    <script>
      $("#test").click( function () {  
        console.log("test");
      } )
    </script>
@endsection

@section('content')
    <h3 id="test">test</h3>
@endsection