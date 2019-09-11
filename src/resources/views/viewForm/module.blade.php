@extends('layouts.app')

@section('content')

<module-index  name="{!! $moduleName !!}"  forms="{{ json_encode($forms) }}" ></module-index>

@endsection
