<div class="row">
    <div class="col-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Menambah Data Anggota Koperasi</h3>
            </div>
            <div class="card-body">
                <form action="#" class="form-horizontal" method="POST" enctype="multipart/form-data" id="form">
                    <div class="card-body">
                        <div class="card card-info">
                            <div class="card-header mb-3" style="border-radius: 5px;">
                                <h3 class="card-title">Informasi Pribadi</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="id_nasabah" class="col-sm-2 col-form-label">Id <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="id_nasabah" id="id_nasabah" value="<?= $data_detail->id_nasabah?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="no_ktp" class="col-sm-2 col-form-label">No KTP <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="no_ktp" id="no_ktp" placeholder="Nomor KTP" value="<?= $data_detail->no_ktp ?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="full_name" class="col-sm-2 col-form-label">Nama Lengkap <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="full_name" id="full_name" placeholder="Nama lengkap" value="<?= $data_detail->full_name?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="address" class="col-sm-2 col-form-label">Alamat <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <textarea disabled class="form-control" rows="4" name="address" id="address" placeholder="Alamat"><?= $data_detail->address ?></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="contact" class="col-sm-2 col-form-label">No HP <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled ="" class="form-control" name="contact" id="contact" placeholder="Nomor Telpon" value="<?= $data_detail->contact?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pob" class="col-sm-2 col-form-label">Tempat Lahir <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-5">
                                <input type="text" disabled="" class="form-control" name="pob" id="pob" placeholder="Tempat Lahir" value="<?= $data_detail->pob?>">
                                <span class="invalid-feedback"></span>
                            </div>
                            <label for="dob" class="col-sm-1 col-form-label">Tanggal <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-4">
                                <input type="date" disabled="" class="form-control" name="dob" id="dob" placeholder="Tanggal Lahir" value="<?= $data_detail->dob?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mothers_name" class="col-sm-2 col-form-label">Nama Ibu Kandung <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled="" class="form-control" name="mothers_name" id="mothers_name" placeholder="Nama Ibu Kandung" value="<?= $data_detail->mothers_name?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="email" id="email" placeholder="Email" value="<?= $data_detail->email?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marital_status" class="col-sm-2 col-form-label">Status Perkawinan <span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select disabled="" class="form-control select2" name="marital_status" data-placeholder="Pilih Status Perkawinan" tabindex="2">
                                    <?php foreach ($marital_status as $value) {
                                        if ($value->id == $data_detail->marital_status) { ?>
                                            <option value="<?= $value->id ?>" selected><?= $value->meta_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $value->id ?>"><?= $value->meta_name ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="marital_status">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="profession" class="col-sm-2 col-form-label">Pekerjaan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select class="form-control select2" disabled="" name="profession" data-placeholder="Pilih Profesi" tabindex="2">
                                    <?php foreach ($profession as $value) {
                                        if ($value->id == $data_detail->profession) { ?>
                                            <option value="<?= $value->id ?>" selected><?= $value->meta_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $value->id ?>"><?= $value->meta_name ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="profession">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_name" class="col-sm-2 col-form-label">Nama Perusahaan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="company_name" id="company_name" placeholder="Nama Perusahaan" value="<?= $data_detail->company_name?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_address" class="col-sm-2 col-form-label">Alamat Perusahaan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" disabled="" rows="4" name="company_address" id="company_address" placeholder="Alamat Perusahaan"><?= $data_detail->company_address?></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company_tlp" class="col-sm-2 col-form-label">No Telp Perusahaan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" class="form-control" disabled="" name="company_tlp" id="company_tlp" placeholder="No telp Perusahaan" value="<?= $data_detail->company_tlp?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="job_position" class="col-sm-2 col-form-label">Jabatan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled="" class="form-control" name="job_position" id="job_position" placeholder="jabatan" value="<?= $data_detail->job_position?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="take_home_pay" class="col-sm-2 col-form-label">Penghasilan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled="" class="form-control" name="take_home_pay" id="take_home_pay" placeholder="penghasilan" value="<?= $data_detail->take_home_pay?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="long_working" class="col-sm-2 col-form-label">Lama Bekerja<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled="" class="form-control" name="long_working" id="long_working" placeholder="Lama Bekerja" value="<?= $data_detail->long_working?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="employee_status" class="col-sm-2 col-form-label">Status Karyawan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select disabled="" class="form-control select2" name="employee_status" data-placeholder="Pilih Status Karyawan" tabindex="2">
                                    <?php foreach ($employee_status as $value) {
                                        if ($value->id == $data_detail->employee_status) { ?>
                                            <option value="<?= $value->id ?>" selected><?= $value->meta_name ?></option>
                                        <?php } else { ?>
                                            <option value="<?= $value->id ?>"><?= $value->meta_name ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <input type="hidden" id="employee_status">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <!-- fix this ge -->
                        <div class="form-group row">
                            <label for="img_ktp" class="control-label col-lg-2">Upload KTP</label>
                            <div class="col-lg-10">
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="img_ktp" id="img_ktp">
                                        <span class="invalid-feedback"></span>
                                        <label class="custom-file-label" for="img_ktp">Cari Foto</label>
                                    </div>
                                    <img id="imgPreview" src="#" alt="your image" width="200px" style="border: 1px solid; border-radius: 10px; display: none;" />
                                </div>
                            </div>
                        </div>
                        <div class="card card-info">
                            <div class="card-header mb-3" style="border-radius: 5px;">
                                <h3 class="card-title">Kerabat yang dapat dihubungi</h3>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="family_name" class="col-sm-2 col-form-label">Nama Lengkap<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" class="form-control" name="family_name" id="family_name" placeholder="Nama keluarga atau kerabat" value="<?= $data_detail->family_name?>">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="family_contact" class="col-sm-2 col-form-label">No Hp<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="tel" disabled="" value="<?= $data_detail->family_contact?>" class="form-control" name="family_contact" id="family_contact" placeholder="No Tlp Kerabat">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="family_address" class="col-sm-2 col-form-label">Alamat<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                            <textarea disabled class="form-control " rows="4" name="family_address" id="family_address" placeholder="Alamat Kerabat"><?= $data_detail->family_address?></textarea>
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="family_relationship_status" class="col-sm-2 col-form-label">Hubungan<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" disabled="" value="<?= $data_detail->family_relationship_status?>" class="form-control" name="family_relationship_status" id="family_relationship_status" placeholder="Hubungan dengan kerabat">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="is_join_come" class="col-sm-2 col-form-label">Apa Join Income<span style="color:#FF0000">*</span></label>
                            <div class="col-sm-10">
                                <select disabled="" name="is_join_come" data-placeholder="Pilih ..." class="form-control select2" tabindex="2" required>
                                    <?php $data_join = $data_detail->is_join_come;
                                    if($data_join == "Y"){ ?>
                                        <option value="Y">Yes</option> 
                                    <?php }
                                    else if($data_join =="N") {?>
                                        <option value="N">No</option> 
                                    <?php }?>
                                </select>
                                <input type="hidden" id="is_join_come">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div> 
                        
                        
                        <!-- partner's joining -->
                        <div class="join_income" id="join_income">
                            <div class="card card-info">
                                <div class="card-header my-3" style="border-radius: 5px;">
                                    <h3 class="card-title">partner's identity (if participating)</h3>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_ktp" class="col-sm-2 col-form-label">No KTP<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_ktp?>" class="form-control" name="partner_ktp" id="partner_ktp" placeholder="Nomor Induk Kependudukan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_name" class="col-sm-2 col-form-label">Nama Lengkap<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_name?>"class="form-control" name="partner_name" id="partner_name" placeholder="Nama Kerabat">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_address" class="col-sm-2 col-form-label">Alamat<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control" rows="4" name="partner_address" id="partner_address" placeholder="Alamat Rumah"><?= $data_detail->partner_address?></textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_contact" class="col-sm-2 col-form-label">No Hp<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_contact?>" class="form-control" name="partner_contact" id="partner_contact" placeholder="No Tlp Kerabat">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_pob" class="col-sm-2 col-form-label">Tempat Lahir <span style="color:#FF0000">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_pob?>"class="form-control" name="partner_pob" id="partner_pob" placeholder="Tempat Lahir">
                                    <span class="invalid-feedback"></span>
                                </div>
                                <label for="partner_dob" class="col-sm-1 col-form-label">Tanggal <span style="color:#FF0000">*</span></label>
                                <div class="col-sm-4">
                                    <input type="date" disabled="" value="<?= $data_detail->partner_dob?>" class="form-control" name="partner_dob" id="partner_dob" placeholder="Tanggal Lahir">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_mothers_name" class="col-sm-2 col-form-label">Nama Ibu Kandung <span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_mothers_name?>" class="form-control" name="partner_mothers_name" id="partner_mothers_name" placeholder="Nama Ibu Kandung">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" disabled="" value="<?= $data_detail->partner_email?>" class="form-control" name="partner_email" id="partner_email" placeholder="Email">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_profession" class="col-sm-2 col-form-label">Pekerjaan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <select disbaled="" class="form-control select2" name="partner_profession"  data-placeholder="Pilih Profesi" tabindex="2">
                                        <?php foreach ($profession as $value) {
                                            if ($value->id == $data_detail->partner_profession) { ?>
                                                <option value="<?= $value->id ?>" selected><?= $value->meta_name ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $value->id ?>"><?= $value->meta_name ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="partner_profession">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_comp_name" class="col-sm-2 col-form-label">Nama Perusahaan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="tel" disabled="" value="<?= $data_detail->partner_comp_name?>" class="form-control" name="partner_comp_name" id="partner_comp_name" placeholder="Nama Perusahaan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_comp_address" class="col-sm-2 col-form-label">Alamat Perusahaan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <textarea disabled="" value="<?= $data_detail->partner_comp_address?>" class="form-control " rows="4" name="partner_comp_address" id="partner_comp_address" placeholder="Alamat Perusahaan"></textarea>
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_comp_contact" class="col-sm-2 col-form-label">No Telp Perusahaan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input disabled="" value="<?= $data_detail->partner_comp_contact?>" type="text" class="form-control" name="partner_comp_contact" id="partner_comp_contact" placeholder="No telp Perusahaan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_position" class="col-sm-2 col-form-label">Jabatan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input disabled="" value="<?= $data_detail->partner_position?>" type="text" class="form-control" name="partner_position" id="partner_position" placeholder="Jabatan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_income" class="col-sm-2 col-form-label">Penghasilan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled="" value="<?= $data_detail->partner_income?>"name="partner_income" id="partner_income" placeholder="Penghasilan">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_long_working" class="col-sm-2 col-form-label">Lama Bekerja<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" disabled="" value="<?= $data_detail->partner_long_working?>" name="partner_long_working" id="partner_long_working" placeholder="Lama Bekerja">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="partner_emp_status" class="col-sm-2 col-form-label">Status Karyawan<span style="color:#FF0000">*</span></label>
                                <div class="col-sm-10">
                                    <select disabled="" class="form-control select2" name="partner_emp_status" data-placeholder="Pilih Status Karyawan" tabindex="2">
                                        <?php foreach ($employee_status as $value) {
                                            if ($value->id == $data_detail->partner_emp_status) { ?>
                                                <option value="<?= $value->id ?>" selected><?= $value->meta_name ?></option>
                                            <?php } else { ?>
                                                <option value="<?= $value->id ?>"><?= $value->meta_name ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <input type="hidden" id="partner_emp_status">
                                    <span class="invalid-feedback"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="parther_img_ktp" class="control-label col-lg-2">Upload KTP</label>
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="partner_img_ktp" id="partner_img_ktp">
                                            <span class="invalid-feedback"></span>
                                            <label class="custom-file-label" for="partner_img_ktp">Cari Foto</label>
                                        </div>
                                        <img id="imgPreviewKTP" src="#" alt="your image" width="200px" style="border: 1px solid; border-radius: 10px; display: none;" />
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </form>
                <div class="col-lg-10">
                    <a href="<?= base_url() ?>data-anggotah" class="btn btn-default "><i class="fa fa-step-backward"></i> Cancel</a>
                    <!-- <button type="button" class="btn btn-primary" id="btn-save" onclick="save('add')"><i class="fa fa-save"></i> Save</button> -->
                    <a href="<?= base_url() ?>data_anggota/saveData/add" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>