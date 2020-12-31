<!--Basic Elements-->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
            <div class="panel-heading panel-heading-divider">@if($edit) Editar Usuário {{ $employee->name }} @else Novo Usuário @endif
                <span class="panel-subtitle"></span>
            </div>
            <div class="panel-body">
                @if($edit)
                    <form action="{{ route('employee.update', ['id' => $employee]) }}" method="POST" style="border-radius: 0px;"
                          class="form-horizontal group-border-dashed" enctype="multipart/form-data">
                    @method('PUT')
                @else
                    <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data">
                @endif

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Input Text</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Input Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Placeholder Input</label>
                        <div class="col-sm-6">
                            <input type="text" placeholder="Placeholder text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Disabled Input</label>
                        <div class="col-sm-6">
                            <input type="text" disabled="disabled" placeholder="Disabled input text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Readonly Input</label>
                        <div class="col-sm-6">
                            <input type="text" readonly="readonly" value="Readonly input text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Textarea</label>
                        <div class="col-sm-6">
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
