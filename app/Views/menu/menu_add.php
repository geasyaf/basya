<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add</h3>
            </div>
            <div class="card-body"> 
                <form action="<?= base_url('menu/saveData/add') ?>" class="form-horizontal" method="POST" enctype="multipart/form-data" id="form">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="page_name" class="col-sm-2 col-form-label">Menu Name <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="page_name" id="page_name" placeholder="Menu Name">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="icon" id="icon" placeholder="fa fa-user">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Menu Type <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="type_menu" data-placeholder="Pilih Tipe Menu ..." tabindex="2">
                                    <option value=""></option>
                                    <option value="main">Main Menu</option>
                                    <option value="page">Page</option>
                                    <option value="separator">Separator</option>
                                </select>
                                <input type="hidden" id="type_menu">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Parent Menu</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="parent" id="parent" data-placeholder="Pilih Parent Menu ..." tabindex="2">
                                    <option value=""></option>
                                    <?php foreach ($data_parent as $value) { ?>
                                        <option value="<?= $value->id ?>"><?= $value->page_name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Show</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="show" id="show" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-lg-10">
                    <a href="<?= base_url() ?>menu" class="btn btn-default "><i class="fa fa-step-backward"></i> Cancel</a>
                    <button type="button" class="btn btn-primary" id="btn-save" onclick="save('add')"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>