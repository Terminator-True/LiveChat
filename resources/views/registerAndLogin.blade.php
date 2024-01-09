
@extends('layout.app')

@section('content')
<div style="height: 100%" class="container d-flex align-items-center justify-content-center">
    <div id="register" class="container" style="margin: auto">
        <div class="login-page">
            <div class="form">
            <form method="POST"  action="{{ route('user.register') }}" class="register-form">
                @csrf
                <input type="text" placeholder="name" name='name'/>
                <input type="text" placeholder="nick" name='nick'/>
                <input type="password" placeholder="password" name='password'/>
                <input type="text" placeholder="email address"name='email'/>
                <button class="button_piu">create</button>
                <p class="message">Already registered? <a href="#">Sign In</a></p>
            </form>

            <form method="POST" action="{{ route('user.login') }}" class="login-form">
                @csrf
                <input type="text" placeholder="email" name='email'/>
                <input type="password" placeholder="password" name='password'/>
                <button class="button_piu">login</button>
                <p class="message">Not registered? <a href="#">Create an account</a></p>
            </form>
            </div>
        </div>
        @isset($error)
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <strong>Error!</strong> {{ $error }}
            </div>
        @endisset
    </div>
</div>


<script>
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>
@endsection
