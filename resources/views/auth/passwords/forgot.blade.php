<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="https://mecanise.com.br/logo/logo_bw.jpeg">
    <title>Mecanise</title>
    <link rel="stylesheet" type="text/css" href="../../assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="../../assets/lib/material-design-icons/css/material-design-iconic-font.min.css"/>
    <link rel="stylesheet" href="../../assets/css/style.css" type="text/css"/>
</head>
<body class="be-splash-screen">
<div class="be-wrapper be-login">
    <div class="be-content">
        <div class="main-content container-fluid">
            <div class="splash-container forgot-password">
                <div class="panel panel-default panel-border-color panel-border-color-primary">
                    <div class="panel-heading">
                        <img src="https://mecanise.com.br/logo/logo_bw.jpeg" alt="logo" width="130" height="130" class="logo-img">
                        <span class="splash-description">Esqueceu sua senha?</span>
                    </div>
                    <div class="panel-body">

                        <p>Não se preocupe, vamos lhe enviar um email com as informações de recuperação de senha</p>
                        <div class="form-group xs-pt-20">
                            <input type="email" name="email" required placeholder="Seu Email" autocomplete="off"
                                   class="form-control" id="email">
                        </div>
                        <p class="xs-pt-5 xs-pb-20 text-center"><a href="{{ url('/login') }}">Voltar para login</a></p>
                        <div class="form-group xs-pt-5">
                            <button type="submit" class="btn btn-block btn-xl" id="forgot_password" style="color: floralwhite;background-color: black;"
                                    onclick="forgot_password();">
                                Recuperar senha
                            </button>
                            <div class="progress" style="display:none;">
                                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%; display:none;"></div>
                            </div>
                        </div>

                    </div>
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
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
