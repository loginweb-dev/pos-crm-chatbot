@extends('layouts.master')

@section('content')
<br>
<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-8 offset-md-2">
            @php
                $negosios = App\Negocio::orderBy('created_at', 'desc')->get();
            @endphp
            <table class="table table-responsive table-sm" id="miresult">
                <tbody>
                    @foreach($negosios as $item)
                    <tr>
                        <td class="text-center">
                            <img src="{{ setting('admin.url').'storage/'.$item->logo }}" alt="" class="img-fluid img-thumbnail">
                            {{-- <br>
                            {{ $item->name }} --}}
                            <br>
                            <a class="btn btn-sm btn-primary" href="{{ $item->url }}">Catalogo</a>
                            <a class="btn btn-sm btn-dark" href="{{ $item->url }}">Ubicacion</a>
                            <a class="btn btn-sm btn-success" href="{{ $item->url }}">Whatsapp</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
