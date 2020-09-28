

<div class="col-md-10">
    <p class="text-center" style="font-size: 30px;">Ordens de Serviços em Aberto: {{ $qtde_model }}</p>
    <table class="table table-style table-hover">
        <thead class="">
        <tr>
            <th scope="col">#</th>
            <th scope="col">Proprietário <i class="fas fa-chevron-down re-order" onclick="reorder('owner_name')"></i></th>
            <th scope="col">Veículo <i class="fas fa-chevron-down re-order" onclick="reorder('vehicle_name')"></i> </th>
            <th scope="col">Finalizado em <i class="fas fa-chevron-down re-order" onclick="reorder('done_at')"></i></th>
            <th scope="col">
                <a href="{{ route('order.create') }}" class="btn btn-success btn-sm" title="Criar Ordem de Serviço" style="margin-left: 30px; padding-right: 0px;">
                    <i class="fas fa-plus"></i>
                </a>
            </th>
        </tr>
        </thead>
        <tbody id="tbody-search" style="display:none;"></tbody>
        <tbody id="tbody-main">
        @foreach($orders as $order)
            <tr class="row100 body" id="model_{{ $order->id }}">
                <th scope="row"><a style="color: #343434;" href="{{ route('order.edit', ['id' => $order->id]) }}">{{ '#' . $order->code }}</a></th>
                <td><a href="{{ route('person.edit', ['id' => $order->owner_id]) }}" class="car_model">{{ $order->owner_name }}</a></td>
                <td><a href="{{ route('vehicle.edit', ['id' => $order->vehicle_id]) }}">{{ $order->vehicle_name }}</a></td>
                <td><span>{{ $order->conclusion_at }}</span></td>
                <td>
                    <div class="row">
                        <div class="dropdown">
                            <button
                                class="btn btn-default btn-outline-primary btn-sm dropdown-toggle"
                                type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" title="Status do Veículo">
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
                    <a href="{{ route('order.edit', ['id' => $order->id]) }}" class="btn btn-sm btn-outline-info" title="Editar Ordem de Serviço">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delete_order({!! $order->id !!})" title="Excluir Ordem de Serviço">
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


    <input type="hidden" value="{{ $offset }}" id="offset">
</div>

