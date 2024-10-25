<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Adding Data Product</h3>
            </div>
            <div class="card-body"> 
                <form action="<?= base_url('produk_master/saveData/add') ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" id="form">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="prod_name" class="col-sm-2 col-form-label">Nama Produk <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="prod_name" id="prod_name" placeholder="Nama">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prod_desc" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="2" name="prod_desc" id="prod_desc" placeholder="Deskripsi Produk"></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tipe Produk <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control chzin" name="prod_type" data-placeholder="Pilih Tipe Produk ..." tabindex="2">
                                    <option value="" disabled selected>Pilih Tipe Produk ...</option> 
                                    <option value="F">Funding</option>
                                    <option value="L">Landing</option>
                                </select>
                                <input type="hidden" id="prod_type">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_active" class="col-sm-2 col-form-label">Aktif</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="is_active" id="is_active" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-lg-10">
                    <a href="<?= base_url() ?>produk_master" class="btn btn-default "><i class="fa fa-step-backward"></i> Cancel</a>
                    <button type="button" class="btn btn-primary" id="btn-save" onclick="save('add')"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>