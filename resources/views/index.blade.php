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
    <link rel="stylesheet" href="../../css/common.css">
    <link rel="stylesheet" href="../../css/loading.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../css/util.css">
    <link rel="stylesheet" type="text/css" href="../../css/main.css">

</head>


<body>

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


    <div class="limiter" style="margin-top: 40px;">
        <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100 ver1 m-b-110" style="display:none;">
                    <div class="table100-head">
                        <table>
                            <thead>
                            <tr class="row100 head">
                                <th class="cell100 column1">Class name</th>
                                <th class="cell100 column2">Type</th>
                                <th class="cell100 column3">Hours</th>
                                <th class="cell100 column4">Trainer</th>
                                <th class="cell100 column5">Spots</th>
                            </tr>

                            </thead>
                        </table>
                    </div>

                    <div class="table100-body js-pscroll">
                        <table>
                            <tbody>
                            <tr class="row100 body">
                                <td class="cell100 column1">Like a butterfly</td>
                                <td class="cell100 column2">Boxing</td>
                                <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                                <td class="cell100 column4">Aaron Chapman</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Mind & Body</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Adam Stewart</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Crit Cardio</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">9:00 AM - 10:00 AM</td>
                                <td class="cell100 column4">Aaron Chapman</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Wheel Pose Full Posture</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">7:00 AM - 8:30 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Playful Dancer's Flow</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Zumba Dance</td>
                                <td class="cell100 column2">Dance</td>
                                <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">20</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Cardio Blast</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Pilates Reformer</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Supple Spine and Shoulders</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">6:30 AM - 8:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Yoga for Divas</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">20</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Virtual Cycle</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">20</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Like a butterfly</td>
                                <td class="cell100 column2">Boxing</td>
                                <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                                <td class="cell100 column4">Aaron Chapman</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Mind & Body</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Adam Stewart</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Crit Cardio</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">9:00 AM - 10:00 AM</td>
                                <td class="cell100 column4">Aaron Chapman</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Wheel Pose Full Posture</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">7:00 AM - 8:30 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Playful Dancer's Flow</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Zumba Dance</td>
                                <td class="cell100 column2">Dance</td>
                                <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">20</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Cardio Blast</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Pilates Reformer</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">10</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Supple Spine and Shoulders</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">6:30 AM - 8:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">15</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Yoga for Divas</td>
                                <td class="cell100 column2">Yoga</td>
                                <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                                <td class="cell100 column4">Donna Wilson</td>
                                <td class="cell100 column5">20</td>
                            </tr>

                            <tr class="row100 body">
                                <td class="cell100 column1">Virtual Cycle</td>
                                <td class="cell100 column2">Gym</td>
                                <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                                <td class="cell100 column4">Randy Porter</td>
                                <td class="cell100 column5">20</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="table100 ver3 m-b-110" style="display: none;">
                <div class="table100-head">
                    <table>
                        <thead>
                        <tr class="row100 head">
                            <th class="cell100 column1">Class name</th>
                            <th class="cell100 column2">Type</th>
                            <th class="cell100 column3">Hours</th>
                            <th class="cell100 column4">Trainer</th>
                            <th class="cell100 column5">Spots</th>
                        </tr>
                        </thead>
                    </table>
                </div>

                <div class="table100-body js-pscroll">
                    <table>
                        <tbody>
                        <tr class="row100 body">
                            <td class="cell100 column1">Like</td>
                            <td class="cell100 column2">Boxing</td>
                            <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                            <td class="cell100 column4">Aaron Chapman</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Mind & Body</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Adam Stewart</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Crit Cardio</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">9:00 AM - 10:00 AM</td>
                            <td class="cell100 column4">Aaron Chapman</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Wheel Pose Full Posture</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">7:00 AM - 8:30 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Playful Dancer's Flow</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Zumba Dance</td>
                            <td class="cell100 column2">Dance</td>
                            <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">20</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Cardio Blast</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Pilates Reformer</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Supple Spine and Shoulders</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">6:30 AM - 8:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Yoga for Divas</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">20</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Virtual Cycle</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">20</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Like a butterfly</td>
                            <td class="cell100 column2">Boxing</td>
                            <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                            <td class="cell100 column4">Aaron Chapman</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Mind & Body</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Adam Stewart</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Crit Cardio</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">9:00 AM - 10:00 AM</td>
                            <td class="cell100 column4">Aaron Chapman</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Wheel Pose Full Posture</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">7:00 AM - 8:30 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Playful Dancer's Flow</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Zumba Dance</td>
                            <td class="cell100 column2">Dance</td>
                            <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">20</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Cardio Blast</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">5:00 PM - 7:00 PM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Pilates Reformer</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">10</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Supple Spine and Shoulders</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">6:30 AM - 8:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">15</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Yoga for Divas</td>
                            <td class="cell100 column2">Yoga</td>
                            <td class="cell100 column3">9:00 AM - 11:00 AM</td>
                            <td class="cell100 column4">Donna Wilson</td>
                            <td class="cell100 column5">20</td>
                        </tr>

                        <tr class="row100 body">
                            <td class="cell100 column1">Virtual Cycle</td>
                            <td class="cell100 column2">Gym</td>
                            <td class="cell100 column3">8:00 AM - 9:00 AM</td>
                            <td class="cell100 column4">Randy Porter</td>
                            <td class="cell100 column5">20</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>




    <div class="content"></div>


    <div class="menu-container" >
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


                <li class="menu_li">
                    <a href="javascript:"><i class="fas fa-car-side"></i> Veículos</a>
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
                    <a href="javascript:"> Novo</a>
                </li>
                <li>
                    <a href="javascript:"> Lista de Funcionários</a>
                </li>

                <li>
                    <a href="javascript:"> Lista de Proprietários</a>
                </li>

            </ul>

            <p class="back_menu" onclick="back_menu()">
                <i class="fas fa-arrow-left fa-xs"></i>
                Voltar
            </p>

        </div>

    </div>
</div>




<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="../../js/common.js"></script>
<script src="../../js/loading.js"></script>
<script src="../../js/main.js"></script>
<script src="../../js/select2.min.js"></script>
<script src="../../js/perfect-scrollbar.min.js"></script>
</body>
</html>
