<div class="be-content">
    <div class="page-head">
        <h2 class="page-head-title">Carros Disponíveis</h2>
        <ol class="breadcrumb page-head-nav">
            <li><a href="#">Home</a></li>
            <li class="active">Carros</li>
        </ol>
    </div>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Lista de Carros disponíveis
                        <div class="tools">
                            <span class="icon mdi mdi-download buttons-copy buttons-html5" onclick="copy();"></span>
                            <span class="icon mdi mdi-print" style="margin-left: 10px;"></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table id="table1" class="table table-striped table-hover table-fw-widget">
                            <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Montadora</th>
                                <th>Combustível</th>
                                <th>Fabricação</th>
                                <th>Fim da Fabricação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0; ?>
                                @foreach($cars as $car)
                                    <tr class="@if($i % 2 == 0) odd @else even @endif gradeA" id="model_{{ $car->id }}">
                                        <td><a href="{{ route('cars.edit', ['id' => $car->id]) }}" class="car_model" style="color: #0b0b0b;">{{ $car->model }}</a></td>
                                        <td>{{ $car->brand_name }}</td>
                                        <td>{{ $car->fuel_name }}</td>
                                        <td class="center"> {{ $car->start_year }}</td>
                                        <td class="center"> {{ $car->end_year }}</td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
