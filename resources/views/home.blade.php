
@extends('layout.app')

@section('content')

<x-nav-bar/>
<div style="height: 50%; width:100%;" class="container d-flex align-items-center justify-content-center">

    <div class="container" style="margin: auto;">
        <table class="table shadow-lg" style="width:">
            <thead class="table-dark">
            <tr class="">
                <th scope="col"></th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Usuarios</th>
                <th scope="col">Entrar</th>
            </tr>
            </thead>
            <tbody>
                @isset($chats)
                    @for($i = 0; $i < count($chats); $i++)
                        <tr class="table-light">
                            <th scope="row">{{ $i }}</th>
                            <td>{{ $chats[$i]['name'] }}</td>
                            <td>{{ $chats[$i]['description'] }}</td>
                            <td> {{ $chats[$i]['actual_users'] }} </td>
                            <td> <a href="{{ route('web.chat',$chats[$i]['id']) }}"> <img width=25px src="\img\iniciar-sesion.png" alt=""></a></td>
                        </tr>

                    @endfor
                @endisset

            </tbody>
        </table>
    </div>
</div>
@endsection
