
@extends('layout.app')

@section('content')

<x-nav-bar/>
@if(Auth::user()->is_sa())

    <div class="container justify-content-center" style="margin: auto">
        <button style="margin:15px auto" class="btn btn-dark mx-5 px-5" onclick="crear()"> Crear Chat </button>
    </div>
@endif
<table class="table shadow-lg" style="width:50%;margin:50px auto;">
            <thead class="table-dark p-5" style="">
            <tr class="p-5">
                <th scope="col"></th>
                <th scope="col">Nombre</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Usuarios</th>
                <th scope="col">Opciones</th>
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
                            <td>
                                <a href="{{ route('web.chat',$chats[$i]['id']) }}"> <img width=25px src="{{ asset('\img\iniciar-sesion.png') }}" alt=""></a>
                                @if(Auth::user()->is_sa())
                                    <a onclick="eliminar('{{ $chats[$i]['id'] }}')"> <img width=25px src="{{ asset('img/marca-x.png') }}" alt="" srcset=""> </a>
                                @endif

                            </td>
                        </tr>

                    @endfor
                @endisset

            </tbody>
        </table>


    <script>
        function eliminar(chat_id)
        {
            Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                    }).then( (result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url:"{{ route('admin.eliminar.chat') }}",
                                type:"POST",
                                async: false,
                                data:{
                                    ' _token': '{{ csrf_token() }}',
                                    'chat_id':chat_id,
                                },
                                success:(data)=>{
                                    if (data) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Your file has been deleted.",
                                            icon: "success"
                                        });

                                        setTimeout(() => {
                                                            location.reload();
                                                        }, 1000);
                                    }
                                }
                                });
                            }
                        });
        }

        function crear()
        {
            Swal.fire({
        title: "Create Chat",
        html: `
            <input id="NewChatName" type="text" class="swal2-input" placeholder='Chat Name'>
            <input id="NewChatDescription" type="text" class="swal2-input" placeholder='Chat Description'>
        `,
        focusConfirm: false,
        preConfirm: () => {

            name = document.getElementById("NewChatName").value,
            description = document.getElementById("NewChatDescription").value

            $.ajax({
                url:"{{ route('admin.crear.chat') }}",
                type:"POST",
                async: false,
                data:{
                    ' _token': '{{ csrf_token() }}',
                    'name':name,
                    'description':description
                },
                success:(data)=>{
                    const Toast = Swal.mixin({
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                            toast.addEventListener('mouseenter', Swal.stopTimer)
                                                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                                                        }
                                            })
                                            if (data) {
                                                Toast.fire({
                                                            icon: 'success',
                                                            title: '{{ __("Chat Created succesfully") }}'
                                                        })

                                                        setTimeout(() => {
                                                            location.reload();
                                                        }, 1000);
                                            }else{
                                                Toast.fire({
                                                            icon: 'error',
                                                            title: '{{ __("Error on create chat") }}'
                                                        })
                                            }
                },
                error:(data)=>{
                    // console.log(data)
                }
            })
        }
    });
        }
    </script>
@endsection
