<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">
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
                                <a href="{{ route('vehicle.create') }}" class="btn btn-success btn-sm" title="Criar Veículo" style="margin-left: 30px;">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </th>
                        </tr>

                        </thead>
                    </table>
                </div>

                <div class="table100-body js-pscroll">
                    <table>
                        <tbody>
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
                                        <a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Veículo">
                                            <i class="fas fa-edit"></i>
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
