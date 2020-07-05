<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Peças Cadastradas: {{ $qtde_model }}</p>

    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="selected_car" style="margin-left: 50%;">Selecione um carro para ver informações</label>
                <select name="" id="selected_car" class="" style="margin-left: 50%">
                    <option value="">Selecione um carro</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->model }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="form-body" style="width: 98%;display:none;">
        <div class="form-options" style="margin-top: 15px;">
            <i class="fas fa-cog"></i>
        </div>

        <hr>

        <div class="form-wrapper">
            <ul class="nav nav-pills nav-fill" id="car_info">
                <li class="nav-item">
                    <a class="nav-link active" id="nav-item-car" href="#car_details">Carro</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown"
                       href="#" role="button" aria-haspopup="true" aria-expanded="false">Opções</a>
                    <div class="dropdown-menu">
                        @foreach($systems as $system)
                            <a class="dropdown-item" href="javascript:"
                               id="{{ $system->name }}">{{ $system->name }}
                            </a>
                        @endforeach
                    </div>
                </li>
            </ul>

            <div id="car_details" class="car_details">
                <div class="col-md-4">
                    <p id="car_model"></p>
                </div>
                <div class="col-md-4">
                    <p id="car_brand"></p>
                </div>
                <div class="col-md-4">
                    <p id="car_fuel"></p>
                </div>

            </div>


            <div id="div_Ignição" class="car_details" style="display:none;">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <p>Vela</p>
                            <ul class="list-group">
                                <li class="list-group-item">NGK 123</li>
                                <li class="list-group-item">NGK XYZ</li>
                                <li class="list-group-item">BOSCH 001</li>
                                <li class="list-group-item">Magneti 010</li>
                            </ul>

                            <br>

                        </div>
                    </div>

                    <div class="col-md-5 div-right">
                        <p>Bobina de Ignição: </p>
                        <h4 class="subitems">Código: BI0101MM</h4>
                        <h4 class="subitems">Original: 1042946/ 55229930</h4>
                    </div>
                </div>

            </div>
        </div>
    </div>


    {{--<table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col"> <i class="fas fa-chevron-down re-order" onclick="reorder('name')"></i></th>
            <th scope="col">Modelo <i class="fas fa-chevron-down re-order" onclick="reorder('model')"></i> </th>
            <th scope="col">Marca da Peça <i class="fas fa-chevron-down re-order" onclick="reorder('brand_name')"></i></th>
            <th scope="col">Sistema <i class="fas fa-chevron-down re-order" onclick="reorder('system_name')"></i></th>
            <th scope="col">
                <a href="{{ route('parts.create') }}" class="btn btn-success btn-sm" title="Criar Peça" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($parts as $part)
            <tr class="row100 body" id="model_{{ $part->id }}">
                <th scope="row">{{ $part->id }}</th>
                <td><a href="{{ route('parts.edit', ['id' => $part->id]) }}" class="car_model">{{ $part->name }}</a></td>
                <td><a href="{{ route('cars.edit', ['id' => $part->car_id]) }}">{{ $part->model }}</a></td>
                <td>{{ $part->brand_name }}</td>
                <td>{{ $part->system_name }}</td>
                <td>
                    <a href="{{ route('parts.edit', ['id' => $part->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Peça">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_part({!! $part->id !!})" title="Excluir Peça">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="load-more">
        <button class="btn btn-default btn-outline-dark" id="load-more" onclick="load_more();">
            <i class="fas fa-spinner fa-spin" style="display:none;"></i>
            <i class="fas fa-download"></i>
            <span>Carregar mais resultados</span>
        </button>
    </div>

    <p class="no-results">Não há resultados para exibir, tente pesquisar novamente.</p>


    <input type="hidden" value="{{ $offset }}" id="offset">--}}
</div>
