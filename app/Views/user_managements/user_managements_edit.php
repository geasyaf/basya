<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit</h3>
            </div>
            <div class="card-body">
                <form action="#" class="form-horizontal" method="POST" enctype="multipart/form-data" id="form">
                    <input type="hidden" name="id" value="<?= $data_edit->id ?>">
                    <input type="hidden" name="old_foto" value="<?= $data_edit->foto_user ?>">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="full_name" class="col-sm-2 col-form-label">Full Name <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name" value="<?= $data_edit->full_name ?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Username <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" placeholder="Username" value="<?= $data_edit->username ?>" disabled>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= $data_edit->email ?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Group Level <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="group_level" id="group_level" data-placeholder="Pilih Group level ..." tabindex="2">
                                    <option value=""></option>
                                    <?php foreach ($group_level as $value) {
                                        if ($value['level_name'] == $data_edit->group_level) { ?>
                                            <option value="<?= $value['level_name'] ?>" selected><?= $value['deskripsi'] ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $value['level_name'] ?>"><?= $value['deskripsi'] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
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
                                    <img id="imgPreview" src="<?= base_url() ?>upload/foto_user/<?= $data_edit->foto_user ?>" alt="your image" width="200px" style="border: 1px solid; border-radius: 10px;" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="col-lg-10">
                    <a href="<?= base_url() ?>user-managements" class="btn btn-default "><i class="fa fa-step-backward"></i> Cancel</a>
                    <button type="button" class="btn btn-primary" id="btn-save" onclick="save('edit')"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>