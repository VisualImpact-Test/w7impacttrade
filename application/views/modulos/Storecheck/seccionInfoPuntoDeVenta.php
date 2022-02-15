<div class="col-md-12" style="margin-top: 15px;text-align: center;">
    <div class="mb-3 card">
        <div class="card-header"><i class="fa fa-align-justify" aria-hidden="true"></i> &nbsp;&nbsp;Información de Punto de Venta</div>
        <div class="card-body">
            <form>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">COD VISUAL</label>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm" value="<?= !empty($infoPuntoDeVenta['idCliente']) ? $infoPuntoDeVenta['idCliente'] : '-' ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">COD TIENDA</label>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm" value="<?= !empty($infoPuntoDeVenta['codCliente']) ? $infoPuntoDeVenta['codCliente'] : '-' ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">TIENDA</label>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm" value="<?= !empty($infoPuntoDeVenta['razonSocial']) ? $infoPuntoDeVenta['razonSocial'] : '-' ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">CADENA</label>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm" value="<?= !empty($infoPuntoDeVenta['cadena']) ? $infoPuntoDeVenta['cadena'] : '-' ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">DIRECCIÓN</label>
                    <div class="col-sm-6">
                        <input type="text" readonly class="form-control form-control-sm" value="<?= !empty($infoPuntoDeVenta['direccion']) ? $infoPuntoDeVenta['direccion'] : '-' ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>