<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mecanise | Para quem ama carros</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600">
    <script src="../../js/font-awesome.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


    {{--<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/animate.css">
    <!--===============================================================================================-->

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
    <link rel="stylesheet" type="text/css" href="../../css/form/nouislider.css">--}}
    <!--===============================================================================================-->
    {{--<link rel="stylesheet" type="text/css" href="../../css/form/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/form/main.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/util.css">--}}

    <!--===============================================================================================-->
    {{--<link rel="stylesheet" href="../../css/common.css">--}}
    <link rel="stylesheet" href="../../css/loading.css">
    <link rel="stylesheet" href="../../css/menu.css">
    <link rel="stylesheet" href="../../css/loading_bars.css">


    @if(isset($links))
        @foreach($links as $link)
            <link rel="stylesheet" href="{{ $link }}" type="text/css">
        @endforeach
    @endif
</head>


<body>

{{--@include('loading')--}}


<div class="pre-loading" style="display:block;">
    @include('loading_bars')

    <div class="profile-settings-box">
        <div class="profile-items">

            <a href="{{ route('config.index') }}" id="config" class="user-option-item">
                <i class="fas fa-cog fa-lg"></i>
                Configurações
            </a>

            <a href="javascript:" class="user-option-item">
                <i class="fas fa-user fa-lg"></i>
                Meus Dados
            </a>
            <a href="javascript:" class="user-option-item">
                <i class="fas fa-envelope fa-lg"></i>
                Mensagens
            </a>
            <a href="javascript:" class="user-option-item">
                <i class="fas fa-lock fa-lg"></i>
                Bloquear Tela
            </a>

            <form action="{{ route('logout') }}" method="POST">
                <button type="submit" class="user-option-item">
                    <i class="fas fa-sign-out-alt fa-lg"></i>
                    Sair
                </button>
            </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="top">
                <input type="text" id="general-search-input" class="form-control" placeholder="">

                <div class="search-icon">
                    <i class="fas fa-search" id="general-search-icon" style="display:none;"></i>
                    <i class="fas fa-times" id="general-search-icon-close" style="display:none;"></i>
                </div>


                <div class="icon-profile">
                    <img src="../../images/perfil.png" alt="">
                    <p>Luluzão <i class="fas fa-chevron-down"></i></p>
                </div>


                <!-- Local do Logo -->
                <div class="top-menu">
                    <span class="hide-menu"><<<</span>
                </div>
            </div>

            <div class="menu">
                <div class="menu-topic">
                    <p>Início</p>
                </div>

                <div class="items">
                    <ul>
                        <li class="li-items">
                            <a href="javascript:" class="a-item main-item" id="item-users" style="color: red;">
                                <i class="fas fa-list"></i>
                                <span class="span-item-name">Painel Geral</span>
                            </a>
                        </li>

                        <br>

                        <li class="li-items" >
                            <a href="{{ route('order.index', ['orderBy' => 'null', 'filter' => 'opened']) }}"
                               class="a-item main-item" id="item-os">
                                <i class="fas fa-file-alt"></i>
                                <span class="span-item-name">Ordens de Serviço</span>
                            </a>
                        </li>

                        <br>

                        <li class="li-items" >
                            <a href="{{ route('order.index', ['orderBy' => 'null', 'filter' => 'closed']) }}"
                               class="a-item main-item" id="item-os">
                                <i class="fas fa-file-alt"></i>
                                <span class="span-item-name">Orçamentos</span>
                            </a>
                        </li>

                        <br>

                        <li class="li-items" >
                            <a href="{{ route('employee.index') }}"
                               class="a-item main-item" id="item-os">
                                <i class="fas fa-file-alt"></i>
                                <span class="span-item-name">Usuários do sistema</span>
                            </a>
                        </li>

                        <br>
                        <li class="li-items" >
                            <a href="{{ route('person.index') }}"
                               class="a-item main-item" id="item-os">
                                <i class="fas fa-file-alt"></i>
                                <span class="span-item-name">Clientes</span>
                            </a>
                        </li>

                        <br>
                        <li class="li-items" >
                            <a href="{{ route('vehicle.index') }}" class="a-item main-item" id="item-vehicles">
                                <i class="fas fa-car"></i>
                                <span class="span-item-name">Veículos</span>
                            </a>
                        </li>

                        <br>
                        <li class="li-items">
                            <a href="javascript:" class="a-item main-item" id="item-vehicles" style="color: red;">
                                <i class="fas fa-car"></i>
                                <span class="span-item-name">Produtos</span>
                            </a>
                        </li>

                        <br>
                        <li class="li-items">
                            <a href="javascript:" class="a-item main-item" id="item-vehicles" style="color: red;">
                                <i class="fas fa-car"></i>
                                <span class="span-item-name">Serviços</span>
                            </a>
                        </li>

                        <br>
                        <li class="li-items" >
                            <a href="javascript:" class="a-item main-item" id="item-vehicles" style="color: red;">
                                <i class="fas fa-car"></i>
                                <span class="span-item-name">Funcionários</span>
                            </a>
                        </li>


                        <li class="li-items" style="margin-top: 30px;">
                            <a href="javascript:" class="a-item main-item" id="item-cars">
                                <i class="fas fa-database"></i>
                                <span class="span-item-name">Base de Dados</span> <span class="span-item"> > </span>
                            </a>

                            <ul id="ul-cars" class="ul-subitem">
                                <li class="li-items">
                                    <a href="{{ route('cars.index')}}" class="a-item">
                                        <i class="fas fa-list"></i> Lista Geral
                                    </a>
                                </li>
                                <li class="li-items">
                                    <a href="{{ route('cars.create')}}" class="a-item">
                                        <i class="fas fa-car"></i> Novo Carro
                                    </a>
                                </li>
                                <li class="li-items">
                                    <a href="{{ route('brands.index')}}" class="a-item">
                                        <i class="far fa-copyright"></i>Lista de Montadoras
                                    </a>
                                </li>
                                <li class="li-items">
                                    <a href="{{ route('config.import') }}" class="a-item">
                                        <i class="fas fa-upload"></i>Importar
                                    </a>
                                </li>

                            </ul>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>

    <div class="custom-container">


        {{--<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso</strong> <span>{{ Session::get('success.msg') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Erro!!!</strong> {{ Session::get('error.msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Atenção!!!</strong> {{ Session::get('warning.msg') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>--}}


        @include($route)
    </div>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!--===============================================================================================-->
<script src="../../js/common.js"></script>
<script src="../../js/loading.js"></script>
{{--<script src="../../js/form/general.js"></script>--}}
<!--===============================================================================================-->
{{--<script src="../../js/main.js"></script>
<script src="../../js/select2.min.js"></script>
<script src="../../js/perfect-scrollbar.min.js"></script>--}}
<!--===============================================================================================-->
{{--<script src="../../js/form/animsition.js"></script>
<script src="../../js/form/main.js"></script>
<script src="../../js/form/moment.js"></script>
<script src="../../js/form/daterangepicker.js"></script>
<script src="../../js/form/countdowntime.js"></script>
<script src="../../js/form/nouislider.js"></script>--}}
<!--===============================================================================================-->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<!--===============================================================================================-->
<script type='text/javascript' src='//igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

@if(isset($scripts))
    @foreach($scripts as $script)
        <script src="{{ $script }}" type="text/javascript"></script>
    @endforeach
@endif

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

@if(isset($active) && $active == 0)
    <input type="hidden" id="inactive" value="1">
    <script>resize_options_buttons()</script>
@endif

</body>
</html>
