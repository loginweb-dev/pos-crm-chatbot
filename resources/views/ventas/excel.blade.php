<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Fecha</th>
        <th>Nro Factura</th>
        <th>Nro Autorizacion</th>
        <th>CI/NIT</th>
        <th>Razon Social</th>
        <th>Total</th>
        <th>Debito</th>
        <th>Cod Control</th>
    </tr>
    </thead>
    <tbody>
    @foreach($ventas as $item)
        <tr>
            <td>{{ $item->id }}</td>
            <td>{{ $item->fecha }}</td>
            <td>{{ $item->nro_factura }}</td>
            <td>{{ $dosificacion->nro_autorizacion }}</td>
            <td>{{ $item->cliente->ci_nit }}</td>
            <td>{{ $item->cliente->display }}</td>
            <td>{{ $item->total }}</td>
            <td>{{ $item->total * 0.13 }}</td>
            <td>{{ $item->codigo_control }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
