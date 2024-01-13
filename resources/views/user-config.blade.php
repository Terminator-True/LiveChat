
@extends('layout.app')

@section('content')

<x-nav-bar/>

<div style="height: 80%" class="container d-flex align-items-center justify-content-center">
    <div id="register" class="container" style="margin: auto">
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
                    <input class="form-control form-control-sm" type="file" name="img">
                    <button class="button_piu">Update</button>

                    <p class="message"> <a href="#" onclick="password_change()">Change password</a></p>
                </form>
            </div>
        </div>

    </div>
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
