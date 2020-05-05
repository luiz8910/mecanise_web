<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mecanise | Para quem ama carros</title>

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
    <link rel="stylesheet" type="text/css" href="../../css/form/hamburgers.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/form/animsition.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/form/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/form/nouislider.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/form/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/form/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/util.css">

    <!--===============================================================================================-->
    <link rel="stylesheet" href="../../css/common.css">
    <link rel="stylesheet" href="../../css/loading.css">

    @if(isset($links))
        @foreach($links as $link)
            <link rel="stylesheet" href="{{ $link }}" type="text/css">
        @endforeach
    @endif
</head>


<body style="overflow: hidden;">

@include('loading')

<div class="pre-loading" style="display:none;">
    <div class="plus-btn-pos">
        <div class="plus-btn">
            <i class="fas fa-bars bars"></i>
            <div class="r1"></div>
            <div class="r2"></div>
        </div>
    </div>

    <div class="options">
        <div class="night-mode">
            <i class="fas fa-moon"></i>
        </div>
        <div class="photo">
            <a href="javascript:">
                <img src="../../images/perfil.png" title="Meus Dados">
                <p class="hidden-xs">Luiz F.</p>
            </a>
        </div>
    </div>

    @if(\Session::has('success.msg'))
    <div class="div_alert">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ \Session::get('success.msg') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
    @endif

    @if(\Session::has('error.msg'))
        <div class="div_alert">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ \Session::get('error.msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif


    @include($route)


    <div class="content"></div>


    <div class="menu-container" style="overflow: hidden;">
        <div class="menu-sliders"></div>
        <div class="menu-sliders"></div>
        <div class="menu-sliders"></div>

        <div class="menu">
            <ul class="lvl_1">

                <li class="menu_li">
                    <a href="javascript:">
                        <i class="fas fa-home"></i> Início
                    </a>

                </li>

                <li id="li_home" class="menu_li">
                    <a href="javascript:">
                        <i class="fas fa-users"></i>
                        Usuários
                        <span class="drop_icon"> > </span></a>
                </li>


                <li class="menu_li" id="li_vehicle">
                    <a href="javascript:"><i class="fas fa-car-side"></i> Veículos <span class="drop_icon"> > </span></a>
                </li>
                <li class="menu_li">
                    <a href="javascript:"><i class="fas fa-file-alt"></i> Orçamentos</a>
                </li>
                <li class="menu_li">
                    <a href="javascript:"><i class="fas fa-dollar-sign"></i> Pagamentos</a>
                </li>
            </ul>

            <ul id="menu_item_home" class="menu_subitem lvl_2">
                <li>
                    <a href="javascript:"> Novo <span class="drop_icon"> > </span></a>
                </li>
                <li>
                    <a href="javascript:"> Lista de Funcionários</a>
                </li>

                <li>
                    <a href="javascript:"> Lista de Proprietários</a>
                </li>

            </ul>

            <ul id="menu_item_vehicle" class="menu_subitem lvl_2">
                <li>
                    <a href="{{ route('vehicle.create')}}"><i class="fas fa-plus"></i> Novo Veículo</a>
                </li>

                <li>
                    <a href="{{ route('vehicle.index') }}"><i class="fas fa-list"></i> Lista de Veículos</a>
                </li>

                <li>
                    <a href="{{ route('cars.index') }}"><i class="fas fa-database"></i> Base de Dados</a>
                </li>
            </ul>

            <p class="back_menu" onclick="back_menu()">
                <i class="fas fa-arrow-left fa-xs"></i>
                Voltar
            </p>

        </div>

    </div>
</div>




<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--===============================================================================================-->
<script src="../../js/common.js"></script>
<script src="../../js/loading.js"></script>
<script src="../../js/form/general.js"></script>
<!--===============================================================================================-->
<script src="../../js/main.js"></script>
<script src="../../js/select2.min.js"></script>
<script src="../../js/perfect-scrollbar.min.js"></script>
<!--===============================================================================================-->
<script src="../../js/form/animsition.js"></script>
{{--<script src="../../js/form/main.js"></script>--}}
<script src="../../js/form/moment.js"></script>
<script src="../../js/form/daterangepicker.js"></script>
<script src="../../js/form/countdowntime.js"></script>
<script src="../../js/form/nouislider.js"></script>
<!--===============================================================================================-->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<!--===============================================================================================-->
<script type='text/javascript' src='//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js'></script>

@if(isset($scripts))
    @foreach($scripts as $script)
        <script src="{{ $script }}" type="text/javascript"></script>
    @endforeach
@endif

</body>
</html>
