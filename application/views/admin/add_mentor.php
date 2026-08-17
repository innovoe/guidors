<div class="content-wrapper">
    <?php $this->load->view('admin/include/breadcrumb'); ?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-9 pl-3">
                    <div class="card">
                        <div class="d-flex justify-content-between">
                          <h3 class="box-title"><?php echo trans('create-new') ?> <?php echo trans('mentor') ?></h3>

                            <a href="<?php echo base_url('admin/mentors') ?>" class="mr-3 mb-2 btn btn-secondary btn-sm"><i class="fa fa-angle-left"></i> <?php echo trans('back') ?></a>

                        </div>

                        <form method="post" enctype="multipart/form-data" action="<?php echo base_url('admin/users/add_mentor') ?>" role="form" class="form-horizontal pl-20">
                            <div class="card-body">

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('name') ?> <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('email') ?> <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('password') ?> <span class="text-danger">*</span></label>
                                            <input type="password" name="password" class="form-control" required maxlength="16">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('phone') ?></label>
                                            <input type="text" name="phone" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('gender') ?></label>
                                            <select class="form-control" name="gender">
                                                <option value=""><?php echo trans('select-your-gender') ?></option>
                                                <option value="1"><?php echo trans('male') ?></option>
                                                <option value="2"><?php echo trans('female') ?></option>
                                                <option value="3"><?php echo trans('other') ?></option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('country') ?></label>
                                            <select class="form-control select2" name="country">
                                                <option value=""><?php echo trans('select-your-ountry') ?></option>
                                                <?php foreach ($countries as $country): ?>
                                                    <option value="<?php echo html_escape($country->id) ?>" <?php if ((int) $country->id === (int) settings()->country){echo 'selected';} ?>><?php echo html_escape($country->name) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('time-zone') ?></label>
                                            <select class="form-control select2" name="time_zone">
                                                <option value=""><?php echo trans('select-your-time-zone') ?></option>
                                                <?php foreach ($time_zones as $time): ?>
                                                  <option value="<?php echo html_escape($time->id) ?>" <?php if ((int) $time->id === (int) settings()->time_zone){echo 'selected';} ?>><?php echo html_escape($time->name) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('language') ?></label>
                                            <input type="text" data-role="tagsinput" name="language" value="" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group mb-4">
                                            <label><?php echo trans('category') ?> <span class="text-danger">*</span></label>
                                            <select class="form-control skill_category" name="category" required>
                                                <option value=""><?php echo trans('select-category') ?></option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?php echo html_escape($category->id) ?>"><?php echo html_escape($category->name) ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label><?php echo trans('skill') ?></label>
                                            <select name="skill[]" class="form-control wide w-100 select2" id="category_skill" multiple>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label><?php echo trans('level-of-experience') ?></label>
                                            <select class="form-control" name="level" >
                                                <option value=""><?php echo trans('select-your-experience-level') ?></option>
                                                <?php foreach (get_levels() as $level): ?>
                                                    <option value="<?php echo html_escape($level); ?>">
                                                        <?php echo html_escape($level); ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label><?php echo trans('experience') ?></label>
                                            <select class="form-control" name="experience_year" >
                                                <option value=""><?php echo trans('select-your-experience') ?></option>
                                                <?php for ($i=1 ; $i <31; $i++ ): ?>
                                                    <option value="<?php echo html_escape($i); ?>"><?php echo html_escape($i); ?> Year</option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>

                                     <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label><?php echo trans('company') ?></label>
                                            <input class="form-control" type="text" name="company" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-4">
                                            <label><?php echo trans('designation') ?></label>
                                            <input class="form-control" type="text" name="designation" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label><?php echo trans('respond-in') ?></label>
                                            <div class="input-group ">
                                                <input type="text" width="30%" class="form-control" name="respond_time" placeholder="insert responding day or hour">

                                                <select class="form-control" name="respond_in">
                                                    <option value=""><?php echo trans('select') ?></option>
                                                    <option value="hour"><?php echo trans('hours') ?></option>
                                                    <option value="day"><?php echo trans('days') ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                    <input type="hidden" id="mentor_skill_user_id" value="0">
                                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                                    <button type="submit" class="btn btn-primary mt-2"><?php echo trans('save') ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
