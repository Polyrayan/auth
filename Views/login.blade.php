@extends('navbars.navbar')
@section('content')
  <div class="container login-container">
    <div class="row">
      <div class="col-md-6 login-form-1">
        <h3> Client</h3>
        <form action="" method="post">
          {{  csrf_field()  }}
          <div class="form-group">
            <input type="email" class="form-control" name="mailClient" placeholder="Email *" value="{{ old('mailClient') }}">
            @if ($errors->has('mailClient'))
              <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mailClient') }} </div>  </small>
            @endif
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="passwordClient" placeholder="Mot de passe *">
              @if ($errors->has('passwordClient'))
                <div class="alert alert-danger" role="alert"> {{ $errors->first('passwordClient') }} </div>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" name="loginClient">Se connecter </button>
          </div>
          <div class="form-group">
            <input type="submit" class="btnSubmit" value="facebook" />
          </div>
          <div class="form-group">
            <a href="#" class="ForgetPwd">mot de passe oublié ?</a>
          </div>
        </form>
      </div>

      <div class="col-md-6 login-form-2">
        <h3> Commerçant</h3>
        <form action="" method="post">
          {{  csrf_field()  }}
          <div class="form-group">
            <input type="email" class="form-control" name="mailSeller" placeholder="Email *" value="{{ old('mailSeller') }}">
            @if ($errors->has('mailSeller'))
              <small>  <div class="alert alert-danger" role="alert"> {{ $errors->first('mailSeller') }} </div>  </small>
            @endif
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="passwordSeller" placeholder="Mot de passe *">
              @if ($errors->has('passwordSeller'))
                <div class="alert alert-danger" role="alert"> {{ $errors->first('passwordSeller') }} </div>
            @endif
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary" name="loginSeller">Se connecter </button>
          </div>
          <div class="form-group">
              <a href="#" class="ForgetPwd" value="Login">mot de passe oublié ?</a> <br>
              <div class="text-right">
                  <a href="#admin" class="ForgetPwd" value="Login">admin</a>
              </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
