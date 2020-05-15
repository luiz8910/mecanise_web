

<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">

            <div class="buttons">

                <a href="{{ route('vehicle.create') }}" class="btn btn-outline-success action-btn">
                    <i class="fas fa-plus"></i>
                    Novo Veículo
                </a>

                <button class="btn btn-default btn-outline-info action-btn" id="remove_filters"
                        onclick="remove_filters()">
                    <i class="fas fa-times"></i>
                    Remover Filtros
                </button>



                {{--<label for="search-model" id="label-search-model" style="display:none;">
                    Digite 3 caracteres ou mais
                </label>--}}

            </div>

            <i class="fas fa-search fa-2x search-model" title="Pesquisar"> </i>

            <input type="text" placeholder="Pesquisar..." class="search form-control" id="search-model">

            <br>

            <div class="table100 ver1 m-b-110" id="table_list" style="display:none;">
                <div class="table100-head">
                    <table>
                        <thead>
                        <tr class="row100 head">
                            <th class="cell100 column1">Modelo</th>
                            <th class="cell100 column2">Montadora</th>
                            <th class="cell100 column3">Proprietário</th>
                            <th class="cell100 column4">Ano</th>
                            <th class="cell100 column5">
                            </th>
                        </tr>

                        </thead>
                    </table>
                </div>

                <div class="table100-body js-pscroll">
                    <table>
                        <tbody id="tbody-search" style="display: none;"></tbody>
                        <tbody id="tbody-main">
                        @foreach($vehicles as $vehicle)
                            <tr class="row100 body" id="model_{{ $vehicle->id }}">
                                <td class="cell100 column1"><a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}">{{ $vehicle->model }}</a></td>
                                <td class="cell100 column2">{{ $vehicle->brand }}</td>
                                <td class="cell100 column3">{{ $vehicle->owner_name }}</td>
                                <td class="cell100 column4">{{ $vehicle->year }}</td>
                                <td class="cell100 column5">
                                    <div class="row">
                                        <div class="dropdown">
                                            <button class="btn btn-default btn-outline-primary btn-sm dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Status do Veículo">
                                                <i class="fas fa-filter"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-check"></i>
                                                    Concluído
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-clock"></i>
                                                    Aguardando
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-backward"></i>
                                                    Retorno
                                                </a>
                                            </div>
                                        </div>
                                        <a href="javascript:" class="btn btn-sm btn-outline-info" title="Ordem de Serviço">
                                            <i class="fas fa-file"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" onclick="delete_vehicle({!! $vehicle->id !!})" title="Excluir Veículo">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
