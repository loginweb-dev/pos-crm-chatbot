@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h2>Cupones</h2>
        </div>
        <div class="col-sm-12 col-md-8 offset-md-2">
            @php
                $negosios = App\Cupone::orderBy('created_at', 'desc')->get();
            @endphp
            <code>
                {{ $negosios }}
            </code>
        </div>
    </div>
</div>
<br>
<br>
@endsection

@section('javascript')
<script>
    $(document).ready(function () {

        $("#mireload").attr("hidden",true);
    });
</script>
@endsection
