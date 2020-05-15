<div class="limiter">
    <div class="container-table100">
        <div class="wrap-table100">

            <div class="buttons">

                <a href="{{ route('order.create') }}" class="btn btn-outline-success action-btn">
                    <i class="fas fa-plus"></i>
                    Nova OS
                </a>

                <div class="dropdown action-btn">
                    <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-filter"></i>
                        Filtrar
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('order.index') }}">
                            <i class="fas fa-list list-icon"></i> Todas
                        </a>

                        <a class="dropdown-item" href="{{ route('order.index', ['filter' => 'opened']) }}">
                            <i class="fas fa-book-open list-icon"></i> Em Aberto
                        </a>

                        <a class="dropdown-item"
                           href="{{ route('order.index', ['filter' => 'closed']) }}">
                            <i class="fas fa-check list-icon"></i> Concluídas
                        </a>

                        <a class="dropdown-item" href="{{ route('order.index', ['filter' => 'deleted']) }}">
                            <i class="fas fa-trash list-icon"></i> Excluídas
                        </a>

                        <a class="dropdown-item not-ready" href="javascript:">
                            <i class="fas fa-users"></i> Por proprietário (Em breve)
                        </a>

                        <a class="dropdown-item not-ready" href="javascript:">
                            <i class="fas fa-car"></i> Por Veículo (Em breve)
                        </a>
                    </div>
                </div>

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

            @if(count($orders) == 0)
                <br><br>
                <h4 class="text-center">Não existem Ordens de Serviços, tente alterar filtros ou cadastre uma nova OS</h4>
            @else
                <div class="table100 ver1 m-b-110" id="table_list" style="display:none;">
                    <div class="table100-head">
                        <table>
                            <thead>
                            <tr class="row100 head">
                                <th class="cell100 column1">Código</th>
                                <th class="cell100 column2">Proprietário</th>
                                <th class="cell100 column3">Veículo</th>
                                <th class="cell100 column4">Finalizado em</th>
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
                            @foreach($orders as $order)
                                <tr class="row100 body" id="model_{{ $order->id }}">
                                    <td class="cell100 column1"><a
                                            href="{{ route('order.edit', ['id' => $order->id]) }}">#{{ $order->code }}</a>
                                    </td>
                                    <td class="cell100 column2">{{ $order->owner_name }}</td>
                                    <td class="cell100 column3">{{ $order->vehicle_name }}</td>
                                    <td class="cell100 column4">{{ $order->conclusion_at }}</td>
                                    <td class="cell100 column5">
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

                                            <button class="btn btn-sm btn-outline-danger"
                                                    onclick="delete_order({!! $order->id !!})" title="Excluir OS">
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
            @endif
        </div>
    </div>
</div>
