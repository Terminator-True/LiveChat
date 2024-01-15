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
                                    <div id="chat" class="chat-discussion">
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
                    </div>
                </div>
            </div>
        </div>

    <script>

        Pusher.logToConsole = true;//TEST
        const pusher = new Pusher("{{ config('broadcasting.connections.pusher.key') }}",{cluster:'eu'})
        const channel = pusher.subscribe('public')

        window.onload = (event) => {
            let height = document.getElementById('chat').scrollHeight;
            $('#chat').animate({ scrollTop:height}, 1000);
        };

        const input = document.getElementById('message');


        channel.bind('App\\Events\\ChatEvent', function (datos){
                console.log(datos.message.user_id)
                let dateTime = datos.message.created_at;
                let contenido = datos.message.content
                let chat_id = '{{ $data["chat"]->id }}'

                if (datos && chat_id == datos.message.chat_id) {

                        $.ajax({
                            url:"{{ route('user.recibir') }}",
                            type:"POST",
                            async: false,
                            data:{
                                ' _token': '{{ csrf_token() }}',
                                'user_id':datos.message.user_id,
                            },
                            success:(data)=>{
                                console.log(data);
                                if (data) {
                                    let div = document.createElement('div')
                                    const hoy = new Date(dateTime);
                                    let final_date = hoy.getFullYear()+'-'+hoy.getMonth()+'-'+hoy.getDate()+' '+hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds()

                                    div.innerHTML = ' <div class="chat-message left">'
                                            +'<img class="message-avatar" src="'+data.img+'" alt="">'
                                            +'<div class="message">'
                                                +'<a class="message-author" href="#">'+data.nick+' </a>'
                                                +'<span class="message-date">'+final_date+' </span>'
                                                +'<span class="message-content">'
                                                + contenido
                                                    +'</span>'
                                            +'</div>'
                                        +'</div>'

                                        document.getElementById('chat').appendChild(div)
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

        function enviar() {

            $.ajax({
                        url:"{{ route('chat.enviar') }}",
                        type:"POST",
                        async: false,
                        headers:{
                            'X-Socket-Id': pusher.connection.socket_id
                        },
                        data:{
                            ' _token': '{{ csrf_token() }}',
                            'content':$('#message').val(),
                            'chat_id': '{{ $data["chat"]->id }}'
                        },
                        success:(data)=>{
                            // console.log(data);
                            if (data) {
                                let div = document.createElement('div')
                                const hoy = new Date(data.created_at);
                                let final_date = hoy.getFullYear()+'-'+hoy.getMonth()+'-'+hoy.getDate()+' '+hoy.getHours()+':'+hoy.getMinutes()+':'+hoy.getSeconds()

                                div.innerHTML = ' <div class="chat-message right">'
                                        +'<img class="message-avatar" src="{{ Auth::user()->img }}" alt="">'
                                        +'<div class="message">'
                                            +'<a class="message-author" href="#"> {{ Auth::user()->nick }} </a>'
                                            +'<span class="message-date">'+final_date+' </span>'
                                            +'<span class="message-content">'
                                               + data.content
                                                +'</span>'
                                        +'</div>'
                                    +'</div>'

                                    document.getElementById('chat').appendChild(div)
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




        input.addEventListener("keypress", function(event) {
                // If the user presses the "Enter" key on the keyboard
                if (event.key === "Enter") {
                    setTimeout(() => {
                        event.preventDefault();
                        enviar()
                        input.value = '';
                    }, 500);

                }
        });
    </script>
@endsection
