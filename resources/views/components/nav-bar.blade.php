

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <a class="navbar-brand m-1" href="{{ route('web.home') }}"><img width="40px" src="{{ asset('img\icono.png') }}" alt="" srcset=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
        <li class="nav-item active">
          <a class="nav-link" href="{{ route('web.home') }}">Chats</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.config') }}">Ajustes</a>
        </li>
      </ul>
      <form method="POST" action="{{ route('user.logout') }}" class="form-inline my-2 my-lg-0">
        @csrf
        <button class="btn btn-link my-2 my-sm-0" type="submit">Log-out</button>
    </form>
    </div>
</nav>
