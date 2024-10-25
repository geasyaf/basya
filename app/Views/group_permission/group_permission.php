<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <!-- <a href="<?= base_url() ?>group_permission/add" class='btn btn-info'><i class='fas fa-plus text-white'></i> tambah</a> -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Group Level <span style="color:#FF0000">*</span></label>
                    <div class="col-sm-10">
                        <select class="form-control select2" name="group_level" id="group_level" data-placeholder="Pilih Group level ..." tabindex="2">
                            <option value=""></option>
                            <?php foreach ($group_level as $value) { ?>
                                <option value=""></option>
                                <?php if ($value['level'] == $level) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                } ?>
                                <option value="<?= $value['level_name']; ?>" <?= $selected; ?>><?= $value['deskripsi']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body" id="card_group">
                <table id="group_permission" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>View</th>
                            <th>Add</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>