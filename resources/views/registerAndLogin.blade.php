
@extends('layout.app')

@section('content')
<div style="height: 100%" class="container d-flex align-items-center justify-content-center">
    <div id="register" class="container" style="margin: auto">
        <div class="login-page">
            <div class="form">
            <form method="POST"  action="{{ route('user.register') }}" class="register-form">
                @csrf
                <input class="@error('name') is-invalid @enderror" type="text" placeholder="name" name='name'/>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                <input class="@error('nick') is-invalid @enderror" type="text" placeholder="nick" name='nick'/>

                @error('nick')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input class="@error('password') is-invalid @enderror" type="password" placeholder="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required name='password'/>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

                <input class="@error('email') is-invalid @enderror" type="text" placeholder="email address"name='email'/>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

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

   if (localStorage.getItem('form') == undefined || localStorage.getItem('form') == 'login') {
        localStorage.setItem('form','register')
   } else {
       localStorage.setItem('form','login')
   }
});

window.addEventListener("load", (event) => {
    setTimeout(() => {
        let form = localStorage.getItem('form');
        if(form == 'register')
        {
            $('form').animate({height: "toggle", opacity: "toggle"});

        }
    }, 200);
});

</script>
@endsection
