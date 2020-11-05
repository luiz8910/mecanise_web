<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="https://mecanise.com.br/logo/logo_bw.jpeg">
    <title>Itapeseg</title>
    <link rel="stylesheet" type="text/css" href="../../assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="../../assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css"/>
    <link rel="stylesheet" href="../../css/common.css" type="text/css"/>
</head>
<body class="be-splash-screen">
<div class="be-wrapper be-login">
    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="splash-container forgot-password">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading">
                        <img src="https://mecanise.com.br/logo/logo_bw.jpeg" alt="logo" width="130" height="130" class="logo-img">
                        <span class="splash-description">Redefina sua senha</span>
                    </div>
                    <form action="{{ route('new.password', ['token' => $token]) }}" method="POST">

                        <div class="panel-body">
                            <p class="text-center">Digite sua nova senha nos campos abaixo</p>
                            <div class="form-group xs-pt-20">
                                <input type="password" name="password" required placeholder="Sua nova senha" autocomplete="off" class="form-control" id="password" minlength="8">
                            </div>
                            <div class="form-group xs-pt-20">
                                <input type="password" required placeholder="Confirme sua senha" autocomplete="off" class="form-control" id="password_confirm">
                            </div>
                            <p class="text-center" id="password_span" style="display:none; color: red;">Os campos de senha não são iguais.</p>
                            <p class="xs-pt-5 xs-pb-20 text-center"><a href="{{ url('/login') }}">Voltar para login</a></p>
                            <div class="form-group xs-pt-5">
                                <button type="submit" id="btn_submit" class="btn btn-block btn-primary btn-xl" disabled style="background-color: black; color: floralwhite;">
                                    Recuperar senha
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<script src="../../assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="../../assets/js/main.js" type="text/javascript"></script>
<script src="../../assets/lib/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../js/email.js" type="text/javascript"></script>
<script src="../../js/common.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //initialize the javascript
        App.init();

    });
</script>
@if(Session::has('success.msg'))
    <script>
        $(function (){
            sweet_alert_success('{!! Session::get('success.msg') !!}')
        });
    </script>

@elseif(Session::has('error.msg'))
    <script>
        $(function (){
            sweet_alert_error('{!! Session::get('error.msg') !!}')
        });
    </script>
@endif
</body>
</html>
