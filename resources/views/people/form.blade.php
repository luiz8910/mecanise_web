
<div class="form-body">
    <div class="form-title">
        <p> @if($edit) Editar @else Novo @endif Cliente</p>
    </div>

    <div class="form-options">
        <div class="dropdown dropleft">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="javascript:">
                    <i class="fas fa-user"></i> Novo Proprietário
                </a>
                <a class="dropdown-item" href="javascript:">
                    <i class="fas fa-cog"></i> Novo Funcionário
                </a>
            </div>
        </div>
    </div>

    <hr>

    <div class="form-wrapper">
        @if($edit)
            <form action="{{ route('person.update', ['id' => $person->id]) }}" method="POST">
                @method('PUT')
                <input type="hidden" value="{{ $person->id }}" id="person_id">
                @else
                    <form action="{{ route('person.store') }}" method="POST">
                @endif

                        <input type="hidden" id="role_id" name="role_id" value="@if($edit){{ $person->role_id }}@else{{ $role }}@endif">
                        <div class="row">
                            <div class="col-md-12 col-xs-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                           required placeholder="Digite o nome do seu cliente" value="@if($edit){{ $person->name }}@else{{ old('name') }}@endif">
                                    <span class="form-text text-danger" id="span_person_status" style="display:none;">Insira um valor válido.</span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Digite o email do cliente"
                                           value="@if($edit){{ $person->email }}@else{{ old('email') }}@endif">
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-6">
                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control number" maxlength="14"
                                           placeholder="Digite o CPF do cliente" value="@if($edit){{ $person->cpf }}@else{{ old('cpf') }}@endif">
                                    <span class="form-text text-danger" id="span_cpf_status" style="display: none;">Insira um CPF válido</span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" id="cnpj" name="cnpj" class="form-control"
                                           placeholder="Digite o CNPJ do cliente" value="@if($edit){{ $person->cnpj }}@else{{ old('cnpj') }}@endif">
                                    <span class="form-text text-danger" id="span_cnpj_status" style="display: none;">Insira um valor válido</span>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="cel">Telefone</label>
                                    <input type="text" id="cel" name="cel" class="form-control" required
                                           placeholder="Ex: (15)999999999" value="@if($edit){{ $person->cel }}@else{{ old('cel') }}@endif">
                                    <span id="span_cel_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="cel2">Telefone 2</label>
                                    <input type="text" id="cel2" name="cel2" class="form-control"
                                           placeholder="Ex: (15)999999999" value="@if($edit){{ $person->cel2 }}@else{{ old('cel2') }}@endif">
                                    <span id="span_cel2_status" style="color: red; display:none;"></span>
                                </div>
                            </div>


                        </div>

                        <div class="row">
                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="zip_code">CEP</label>
                                    <input type="text" id="zip_code" name="zip_code" class="form-control number"
                                           placeholder="Ex: 18045-999" maxlength="9" value="@if($edit){{ $person->zip_code }}@else{{ old('zip_code') }}@endif">
                                    <span id="span_zip_code_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-5 col-xs-6">
                                <div class="form-group">
                                    <label for="street">Logradouro</label>
                                    <input type="text" id="street" name="street" class="form-control"
                                           placeholder="Ex: Rua XV de Novembro" value="@if($edit){{ $person->street }}@else{{ old('street') }}@endif">
                                    <span id="span_street_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-2 col-xs-6">
                                <div class="form-group">
                                    <label for="number">Número</label>
                                    <input type="number" id="number" name="number" class="form-control"
                                           placeholder="Ex: 1000" value="@if($edit){{ $person->number }}@else{{ old('number') }}@endif">
                                    <span id="span_number_status" style="color: red; display:none;"></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="district">Bairro</label>
                                    <input type="text" id="district" name="district" class="form-control"
                                           placeholder="Ex: (15)999999999" value="@if($edit){{ $person->district }}@else{{ old('district') }}@endif">
                                    <span id="span_district_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="city">Cidade</label>
                                    <input type="text" id="city" name="city" class="form-control"
                                           placeholder="Digite sua cidade" value="@if($edit){{ $person->city }}@else{{ 'Sorocaba' }}@endif">
                                    <span id="span_city_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-xs-6">
                                <div class="form-group">
                                    <label for="state">UF</label>
                                    <select name="state" id="state" class="form-control">
                                        <option value="">Selecione uma opção</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->initials }}" @if($edit && $person->state == $state->initials) selected @elseif($state->initials == "SP") selected @endif>
                                                {{ $state->state }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span id="span_state_status" style="color: red; display:none;"></span>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <label for="address_reference">Complemento</label>
                                <input type="text" id="address_reference" placeholder="Ex: Casa, Ap 10" name="address_reference"
                                       class="form-control" value="@if($edit){{ $person->address_reference }}@else{{ old('address_reference') }}@endif">
                                <span id="span_address_reference_status" style="color: red; display:none;"></span>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <label for="description">Observações</label>
                                <textarea rows="10" id="description" name="description" placeholder="Digite Informações importantes sobre o cliente"
                                          class="form-control">@if($edit){{ $person->description }}@else{{ old('description') }}@endif</textarea>
                            </div>
                        </div>

                        <br><br>
                        <div class="row">
                            <div class="col-md-12 col-xs-6">
                                <button type="submit" class="btn btn-outline-dark btn-block btn-submit">
                                    <i class="fas fa-check"></i>
                                    Salvar
                                </button>
                            </div>
                        </div>

                    </form>
    </div>



</div>
