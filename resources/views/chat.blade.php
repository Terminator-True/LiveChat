@extends('layout.app')

@section('content')

    <x-nav-bar/>

        <div class="chat wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <strong>{{ $data['chat']->name }}</strong>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox chat-view">
                        <div class="ibox-title">
                            <small class="pull-right text-muted">{{ $data['chat']->description }}</small>
                        </div>
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="chat" class="chat-discussion" style="height: 60vh">
                                        @foreach($data['mensajes'] as $key => $mensaje)
                                            @if($mensaje->user_id != Auth::user()->id)

                                                <div class="chat-message left">
                                                    <img class="message-avatar" src="{{ $mensaje->user->img }}" alt="">
                                                    <div class="message">
                                                        <a class="message-author" href="#"> {{ $mensaje->user->nick }} </a>
                                                        <span class="message-date"> {{ $mensaje->created_at }} </span>
                                                        <span class="message-content">
                                                            {{ $mensaje->content }}

                                                        </span>
                                                        @if($mensaje->type == 'img')

                                                            <img class="w-75" src="{{ $mensaje->image->data }}" alt="">
                                                        @endif
                                                    </div>
                                                </div>
                                            @else

                                                <div class="chat-message right">
                                                    <img class="message-avatar" src="{{ $mensaje->user->img }}" alt="">
                                                    <div class="message">

                                                        <a class="message-author" href="#"> {{ $mensaje->user->nick }} </a>
                                                        <span class="message-date"> {{ $mensaje->created_at }} </span>

                                                        <span class="message-content">
                                                            {{ $mensaje->content }}
                                                        </span>

                                                        @if($mensaje->type == 'img')

                                                        <img class="w-75" src="{{ $mensaje->image->data }}" alt="">
                                                    @endif
                                                    </div>
                                                </div>

                                            @endif


                                        @endforeach

                                        </div>
                                    </div>

                                </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="chat-message-form">
                                        <div class="form-group">
                                            <input id="message" class="form-control message-input" name="content" placeholder="Enter message text and press enter" autocomplete="off"></input>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="file" id="image" class="form-control float-end">
                    </div>
                </div>
            </div>
        </div>

    <script>

    var base64String = null;

    const image = document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            // const fileSizeKB = file.size / 1024 // Tamaño del archivo en KB
            // if (fileSizeKB > 10) {
            //     alert("La imagen excede el límite de 10KB. Por favor, selecciona una imagen más pequeña.");
            //     document.getElementById('image').value = ""; // Limpiar el input si no pasa la validación
            //     return; // Salir de la función
            // }
            const reader = new FileReader();
            reader.onloadend = function() {
                base64String = reader.result; // Solo obtenemos el contenido base64
                // console.log(base64String)
            };
            reader.readAsDataURL(file); // Leer archivo como Data URL (base64)
        }
    });


        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}",{cluster:'eu'})
        const channel = pusher.subscribe('public')

        // Al cargar la página, automáticamente se nos mueve hasta el último mensaje
        window.onload = (event) => {
            let height = document.getElementById('chat').scrollHeight;
            $('#chat').animate({ scrollTop:height}, 1000);
        };

        const input = document.getElementById('message');

        // Escuchamos el evento del Chat
        channel.bind('App\\Events\\ChatEvent', function (datos){
                // console.log(datos.message.user_id)
                let dateTime = datos.message.created_at;
                let contenido = datos.message.content
                // let contenido_img = datos.message.img
                let chat_id = '{{ $data["chat"]->id }}'

                // Si el evento es de éste chat
                if (datos && chat_id == datos.message.chat_id) {

                        $.ajax({
                            url:"{{ route('user.recibir') }}",
                            type:"POST",
                            async: false,
                            data:{
                                ' _token': '{{ csrf_token() }}',
                                'mensaje':datos.message,
                            },
                            success:(data)=>{
                                // console.log(data);
                                if (data) {
                                    let div = document.createElement('div')

                                    // Cambiamos el timestamp para que tenga el mismo formato de fecha
                                     const hoy = new Date(dateTime);
                                    let final_date = hoy.getFullYear()+'-'+hoy.getMonth()+'-'+hoy.getDate()+' '+hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds()
                                    // Creamos el div del mensaje
                                    div.innerHTML = ' <div class="chat-message left">'
                                            +'<img class="message-avatar" src="'+data.user.img+'" alt="">'
                                            +'<div class="message">'
                                                +'<a class="message-author" href="#">'+data.user.nick+' </a>'
                                                +'<span class="message-date">'+final_date+' </span>'
                                                +'<span class="message-content">'
                                                + contenido
                                                    +'</span>'
                                                    // Si el mensaje es una imagen, la añadimos
                                                + '<img class="w-75" src='+data.message?.image?.data+' alt="">'
                                            +'</div>'
                                        +'</div>'
                                        // Añadimos el div anterior
                                        document.getElementById('chat').appendChild(div)

                                        // Esperamos 500 milisegundos y bajamos hasta el último mensaje
                                        setTimeout(() => {
                                            let height = document.getElementById('chat').scrollHeight;
                                            $('#chat').animate({ scrollTop:height}, 1000);
                                        }, 500);
                                }
                            },
                            error:(data)=>{
                                // console.log(data)
                            }
                    });
                        }


            });

        function enviar(base64string=null) {

            $.ajax({
                        url:"{{ route('chat.enviar') }}",
                        type:"POST",
                        async: false,
                        headers:{
                            'X-Socket-Id': pusher.connection.socket_id
                        },
                        data:{
                            ' _token': '{{ csrf_token() }}',
                            'type':base64string!=null ? 'img':'msg',
                            'content': $('#message').val(),
                            'img': base64string,
                            'chat_id': '{{ $data["chat"]->id }}'
                        },
                        success:(data)=>{
                            console.log(data);
                            if (data) {
                                let div = document.createElement('div')
                                const hoy = new Date(data.created_at);
                                // Cambiamos el timestamp para que tenga el mismo formato de fecha

                                let final_date = hoy.getFullYear()+'-'+hoy.getMonth()+'-'+hoy.getDate()+' '+hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds()

                                div.innerHTML = ' <div class="chat-message right">'

                                        +'<img class="message-avatar" src="{{ Auth::user()->img }}" alt="">'
                                        +'<div class="message">'
                                            +'<a class="message-author" href="#"> {{ Auth::user()->nick }} </a>'
                                            +'<span class="message-date">'+final_date+' </span>'
                                            +'<span class="message-content">'
                                            + data.content
                                            +'</span>'
                                            + '<img class="w-75 right" src='+base64string+' alt="">'

                                        +'</div>'
                                    +'</div>'
                                    // Añadimos el div anterior

                                    document.getElementById('chat').appendChild(div)
                                    setTimeout(() => {
                                        let height = document.getElementById('chat').scrollHeight;
                                        $('#chat').animate({ scrollTop:height}, 1000);
                                    }, 500);
                            }
                        },
                        error:(data)=>{
                            console.log(data)
                        }
                    });
        }



        // Al dar al enter enviamos el mensaje y vaciamos el input
        input.addEventListener("keypress", async function(event) {
                // If the user presses the "Enter" key on the keyboard
                if (event.key === "Enter") {
                    event.preventDefault();
                    await enviar(base64String)
                    input.value = '';
                    document.getElementById('image').value = ""; // Resetear el input
                }
        });

    </script>
@endsection
