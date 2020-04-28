<div class="limiter" style="margin-top: 40px;">
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100 ver1 m-b-110" id="table_list" style="display:none;">
                <div class="table100-head">
                    <table>
                        <thead>
                        <tr class="row100 head">
                            <th class="cell100 column1">Modelo</th>
                            <th class="cell100 column2">Montadora</th>
                            <th class="cell100 column3">Versão</th>
                            <th class="cell100 column4">Fabricação</th>
                            <th class="cell100 column5">Fabricação Final</th>
                            <th class="cell100 column6">
                                <a href="{{ route('cars.create') }}" class="btn btn-success btn-sm" title="Criar Carro" style="margin-left: 30px;">
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
                            @foreach($cars as $car)
                                <tr class="row100 body" id="model_{{ $car->id }}">
                                    <td class="cell100 column1"><a href="{{ route('cars.edit', ['id' => $car->id]) }}">{{ $car->model }}</a></td>
                                    <td class="cell100 column2">{{ $car->brand }}</td>
                                    <td class="cell100 column3">{{ $car->version }}</td>
                                    <td class="cell100 column4">{{ $car->start_year }}</td>
                                    <td class="cell100 column5">{{ $car->end_year }}</td>
                                    <td class="cell100 column6">
                                        <a href="{{ route('cars.edit', ['id' => $car->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Carro">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" onclick="delete_car({!! $car->id !!})" title="Excluir Carro">
                                            <i class="fas fa-trash"></i>
                                        </button>
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
