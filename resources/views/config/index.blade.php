
<div class="form-body">
    <div class="form-title">
        <p> Configurações </p>

    </div>

    <div class="form-options">
        <i class="fas fa-cog"></i>
    </div>

    <hr>

    <div class="form-wrapper">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="pagination">Linhas por página</label>
                    <input type="number" id="pagination" name="pagination" value="{{ $pagination }}" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-outline-info" onclick="form_config();">
                    <i class="fas fa-check"></i>
                    Salvar
                </button>
            </div>

        </div>
    </div>

</div>
