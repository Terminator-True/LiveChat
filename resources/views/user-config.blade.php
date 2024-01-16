
@extends('layout.app')

@section('content')

<x-nav-bar/>
<div class="">
        <div class="row" style="width:100%">
            <div class="column">
                <div class="login-page">
                    <div class="form">
                        <form method="POST"  action="{{ route('user.update') }}" class="" enctype="multipart/form-data">
                            @csrf

                            <input class="@error('name') is-invalid @enderror" type="text" placeholder="New name" name='name'/>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                                <input class="@error('nick') is-invalid @enderror" type="text" placeholder="New nick" name='nick'/>


                            @error('nick')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input class="form-control form-control-sm @error('img') is-invalid @enderror" type="file" name="img">
                                @error('img')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            <button class="button_piu">Update</button>

                            <p class="message"> <a href="#" onclick="password_change()">Change password</a></p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="column" style="width:360px;margin: auto">
                <div class="ibox chat-view" style="background: white">
                    <h3 style="padding: 15px">Preview</h3>
                    <div class="ibox-content">
                        <div class="row" >
                            <div class="" >
                                <div class="chat-discussion" style="width: 100%; height:100%">
                                    <div class="chat-message left">
                                        <img class="message-avatar" src="{{ Auth::user()->img }}" alt="">
                                        <div class="message">
                                            <a class="message-author" href="#"> {{ Auth::user()->nick }} </a>
                                            <span class="message-date"> Mon Jan 26 2015 - 18:39:23 </span>
                                            <span class="message-content">
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit
                                                </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>





        {{-- <div class="flex-column chat wrapper wrapper-content animated fadeInRight"> --}}
</div>

<script>

function password_change(){
    Swal.fire({
        title: "Change Password",
        html: `
            <input id="ActualPassword" type="password" class="swal2-input" placeholder='Actual Password'>
            <input id="NewPassword" type="password" class="swal2-input" placeholder='New Password'>
        `,
        focusConfirm: false,
        preConfirm: () => {

            actual_password = document.getElementById("ActualPassword").value,
            new_password = document.getElementById("NewPassword").value

            $.ajax({
                url:"{{ route('user.password.update') }}",
                type:"POST",
                async: false,
                data:{
                    ' _token': '{{ csrf_token() }}',
                    'actual_password':actual_password,
                    'new_password':new_password
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
                                                            title: '{{ __("Password changed succesfully") }}'
                                                        })
                                            }else{
                                                Toast.fire({
                                                            icon: 'error',
                                                            title: '{{ __("Error on change password") }}'
                                                        })
                                            }
                },
                error:(data)=>{
                    console.log(data)
                }
            })
        }
    });



}
</script>
@endsection
