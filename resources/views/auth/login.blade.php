<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Mecanise</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/68123c67f0.js" crossorigin="anonymous"></script>

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../fonts/iconic/css/material-design-iconic-font.min.css">

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/login/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/login/main.css">
    <link rel="stylesheet" type="text/css" href="../../css/common.css">
</head>
<body>


<div class="container-login100" style="background-image: url('images/motor.png');">
    <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
        <form class="login100-form validate-form"  method="POST" action="{{ route('login.post') }}">
            @csrf
            <span class="login100-form-title p-b-37">
                <img src="logo/logo_bw.jpeg" alt="" style="width: 120px;">
            </span>

            <div class="wrap-input100 validate-input m-b-20" data-validate="Digite seu email">
                <input class="input100{{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" id="email"
                       placeholder="Email" value="{{ old('email') }}" required>
                <span class="focus-input100"></span>

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>

            <div class="wrap-input100 validate-input m-b-25" data-validate = "Digite sua senha">
                <input class="input100{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Senha" required>
                <span class="focus-input100"></span>
            </div>


            <label class="switch">

                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>



            <p class="p_switch">Lembrar-me</p>

            <div class="container-login100-form-btn">
                <button class="login100-form-btn" type="submit">
                    Entrar <i class="fas fa-arrow-right" style="display:none; margin-left: 10px;"></i>
                </button>
            </div>

        </form>

            <div class="text-center p-t-57 p-b-20">
                <span class="txt1">
                    Faça Login com
                </span>
            </div>

            <div class="flex-c p-b-60">
                <a href="#" class="login100-social-item">
                    <i class="fa fa-facebook-f"></i>
                </a>

                <a href="#" class="login100-social-item">
                    <img src="images/icons/icon-google.png" alt="GOOGLE">
                </a>
            </div>

            <div class="text-center">
                <a href="#" class="txt2 hov1">
                    Não tem uma conta? Cadastre-se aqui
                </a>
            </div>
        </form>


    </div>
</div>



<div id="dropDownSelect1"></div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script src="../../js/login.js"></script>

</body>
</html>
