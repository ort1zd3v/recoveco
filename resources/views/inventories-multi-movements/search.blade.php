<div class="col-md-6">
    <h2>Búsqueda de productos</h2>
    <div class="d-flex mb-1">
        <div class="w-100">
            <div class="input-group">
                <input id="filter" type="text" class="form-control" placeholder="Buscar por código de barras o nombre">
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger" id="btnClearSearch">
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="ms-2 text-end">
            <button class="btn btn-primary" id="btnSearch">Buscar</button>
        </div>
    </div>

    <div class="col-md">
        <input id="with_inventory" type="checkbox" name="with_inventory" checked>
        <label for="with_inventory">Mostrar solo con inventario</label>
        <table id="pos-products-table" class="table dataTable no-footer">
            <thead>
                <th style="width: 25%">Clave</th>
                <th style="width: 10%">C.</th>
                <th style="width: 45%">Nombre</th>
                <th style="width: 20%">Precio</th>
            </thead>
            <tbody id="pos-products-table-body">
            </tbody>
        </table>
    </div>
    
</div>
