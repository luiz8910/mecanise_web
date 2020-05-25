<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Carros Cadastrados: {{ count($cars) }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Modelo</th>
            <th scope="col">Montadora</th>
            <th scope="col">Versão</th>
            <th scope="col">Fabricação</th>
            <th scope="col">Fabricação Final</th>
            <th scope="col">
                <a href="{{ route('cars.create') }}" class="btn btn-success btn-sm" title="Criar Carro" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody>
            @foreach($cars as $car)
                <tr class="row100 body" id="model_{{ $car->id }}">
                    <th scope="row">{{ $car->id }}</th>
                    <td><a href="{{ route('cars.edit', ['id' => $car->id]) }}" class="car_model">{{ $car->model }}</a></td>
                    <td>{{ $car->brand_name }}</td>
                    <td><span class="car_version">{{ $car->version }}</span></td>
                    <td>{{ $car->start_year }}</td>
                    <td>{{ $car->end_year }}</td>
                    <td>
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
