<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Add</h3>
            </div>
            <div class="card-body">
                <form action="#" class="form-horizontal" method="POST" enctype="multipart/form-data" id="form">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="full_name" class="col-sm-2 col-form-label">Full Name <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Group Level <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="group_level" id="group_level" data-placeholder="Pilih Group level ..." tabindex="2">
                                    <option value=""></option>
                                    <?php foreach ($group_level as $value) { ?>
                                        <option value="<?= $value['level_name']; ?>"><?= $value['deskripsi']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Aktif</label>
                            <div class="col-sm-10">
                                <input type="checkbox" name="aktif" id="aktif" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="Photo" class="control-label col-lg-2">Photo</label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="foto_user" id="foto_user">
                                        <span class="invalid-feedback"></span>
                                        <label class="custom-file-label" for="foto_user">Cari Foto</label>
                                    </div>
                                    <img id="imgPreview" src="#" alt="your image" width="200px" style="border: 1px solid; border-radius: 10px; display: none;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-lg-10">
                    <a href="<?= base_url() ?>user-managements" class="btn btn-default "><i class="fa fa-step-backward"></i> Cancel</a>
                    <button type="button" class="btn btn-primary" id="btn-save" onclick="save('add')"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>