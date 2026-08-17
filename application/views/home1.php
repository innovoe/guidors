<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
/* --------------------------------------------------------------------------
 | Guidors homepage — layout 1
 |
 | Copy marked "PLACEHOLDER COPY" is literal English on purpose. Inventing
 | trans() keys that don't exist in the language file renders blank strings,
 | which is worse than hardcoded text. Move these into the language file and
 | swap them for trans() when the keys are added.
 |
 | Terminology note: the display strings say Guidor / Guidee. The identifiers
 | ($random_mentor, count_mentor_by_category(), base_url('mentors')) stay as
 | they are — renaming those is an app-wide refactor with no user benefit.
 |
 | $random_mentor is an ARRAY OF ARRAYS: $random_mentor[0]['image'].
 | $categories / $features / $workflows are OBJECTS: $c->slug.
 * ------------------------------------------------------------------------ */

/* Which Guidor sits where on the arc: [data index, size class, position class] */
$g_arc = array(
    array(0, 'home-image-lg', 'g-avatar--3'),
    array(1, 'home-image-md', 'g-avatar--2'),
    array(2, 'home-image-sm', 'g-avatar--5'),
    array(3, 'home-image-sm', 'g-avatar--1'),
    array(4, 'home-image-sm', 'g-avatar--4'),
);
?>

<!-- ============================================================ HERO ==== -->
<section class="g-hero pt-10 pb-8">

    <svg class="g-hero__arc" viewBox="0 0 1440 520" preserveAspectRatio="none" aria-hidden="true" focusable="false">
        <path class="g-arc-fill" d="M0,300 C360,120 1080,120 1440,300 L1440,520 L0,520 Z"/>
        <path d="M0,300 C360,120 1080,120 1440,300"/>
        <path d="M0,360 C360,190 1080,190 1440,360"/>
        <path d="M0,240 C360,60 1080,60 1440,240"/>
    </svg>

    <div class="container">

        <div class="g-tabs-wrap">
        <ul class="nav nav-tabs g-tabs" id="myTab" role="tablist">
            <li class="nav-item ml-0">
                <a class="nav-link active" id="one-tab" data-toggle="tab" href="#one" role="tab" aria-controls="One" aria-selected="true"><?php echo trans('mentee') ?></a>
            </li>
            <li class="nav-item ml-0">
                <a class="nav-link" id="two-tab" data-toggle="tab" href="#two" role="tab" aria-controls="Two" aria-selected="false"><?php echo trans('mentor') ?></a>
            </li>
        </ul>
        </div>

        <div class="tab-content" id="myTabContent">

            <!-- ------------------------------------------------ GUIDEE --- -->
            <div class="tab-pane fade show active" id="one" role="tabpanel" aria-labelledby="one-tab">

                <div class="row align-items-center">

                    <div class="col-lg-7 mb-8 mb-lg-0">
                        <div class="g-hero__copy" data-g-reveal>
                            <span class="g-eyebrow mb-4 d-inline-block">Connect &middot; Learn &middot; Grow</span>

                            <h1 class="g-display mb-4">
                                <?php echo lang_value()->site_title ?>
                            </h1>

                            <p class="g-lead w-lg-80 mb-0">
                                <?php echo lang_value()->description ?>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="g-stage" data-g-reveal style="--g-i:1">

                            <div class="g-arc" aria-hidden="true">
                                <svg class="g-arc__line" viewBox="0 0 420 400" preserveAspectRatio="none" focusable="false">
                                    <path d="M20,60 C80,240 200,330 400,300"/>
                                </svg>

                                <?php $ai = 0; foreach ($g_arc as $slot): ?>
                                    <?php
                                        $idx  = $slot[0];
                                        $img  = isset($random_mentor[$idx]['image']) ? $random_mentor[$idx]['image'] : '';
                                        $name = isset($random_mentor[$idx]['name']) ? $random_mentor[$idx]['name'] : '';
                                    ?>
                                    <?php if (!empty($img)): ?>
                                        <div class="g-avatar <?php echo $slot[1] ?> <?php echo $slot[2] ?>"
                                             style="--g-i:<?php echo $ai ?>; background-image:url(<?php echo base_url($img) ?>)"
                                             title="<?php echo html_escape($name) ?>"></div>
                                    <?php else: ?>
                                        <!-- No Guidors onboarded yet: a system mark, not a face
                                             pretending to be a real member. Swaps itself out the
                                             moment get_random_mentors() returns rows. -->
                                        <div class="g-avatar g-avatar--ph <?php echo $slot[1] ?> <?php echo $slot[2] ?>"
                                             style="--g-i:<?php echo $ai ?>">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    <?php endif ?>
                                <?php $ai++; endforeach ?>
                            </div>

                            <!-- ---- signature: the booking moment ---- -->
                            <div class="g-booking" data-g-booking>

                                <div class="g-booking__head">
                                    <?php if (isset($random_mentor[0]['image']) && !empty($random_mentor[0]['image'])): ?>
                                        <div class="home-image-md g-booking__face" style="width:44px;height:44px;background-image:url(<?php echo base_url($random_mentor[0]['image']) ?>)"></div>
                                    <?php else: ?>
                                        <div class="g-avatar--ph home-image-md g-booking__face" style="width:44px;height:44px;position:static;opacity:1;transform:none;box-shadow:none;border:0">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                    <?php endif ?>

                                    <div class="g-booking__meta">
                                        <p class="g-booking__name">
                                            <!-- PLACEHOLDER COPY -->
                                            <?php echo isset($random_mentor[0]['name']) && !empty($random_mentor[0]['name']) ? html_escape($random_mentor[0]['name']) : 'Available Guidor'; ?>
                                            <span class="g-verified" title="Verified"><i class="bi bi-check"></i></span>
                                        </p>
                                        <!-- PLACEHOLDER COPY -->
                                        <p class="g-booking__role">Career &amp; interview guidance</p>
                                    </div>
                                </div>

                                <!-- PLACEHOLDER COPY: day labels -->
                                <div class="g-booking__days">
                                    <span class="g-day">Mon<small>11</small></span>
                                    <span class="g-day">Tue<small>12</small></span>
                                    <span class="g-day">Wed<small>13</small></span>
                                    <span class="g-day">Thu<small>14</small></span>
                                    <span class="g-day">Fri<small>15</small></span>
                                </div>

                                <!-- PLACEHOLDER COPY: slot times -->
                                <div class="g-slots">
                                    <span class="g-slot"><span>4:00 PM</span></span>
                                    <span class="g-slot"><span>5:30 PM</span></span>
                                    <span class="g-slot"><span>7:00 PM</span></span>
                                </div>

                                <div class="g-booking__foot">
                                    <!-- PLACEHOLDER COPY -->
                                    <p class="g-booking__price">45 min &middot; <b>from ৳500</b></p>
                                    <a href="<?php echo base_url('mentors') ?>" class="g-booking__cta">Book a session</a>
                                </div>

                                <!-- PLACEHOLDER COPY -->
                                <div class="g-confirm"><i class="bi bi-check-circle-fill"></i> Session confirmed</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ---- search ---- -->
                <div class="row mt-8 g-search">
                    <div class="col-12" data-g-reveal style="--g-i:2">
                        <div class="home-search style-two position-relative">
                            <form action="<?php echo base_url('home/mentors') ?>" method="get">
                                <div class="row align-items-center">

                                    <div class="col-md-6">
                                        <div class="input-box border-right">
                                            <div class="form-group has-search mb-0">
                                                <span class="bi bi-search text-primary form-control-feedback"></span>
                                                <input type="text" name="mentor_search_name" class="form-control isearch"
                                                       value="<?php echo html_escape($this->input->get('mentor_search_name', true)); ?>"
                                                       placeholder="<?php echo trans('search-by-mentor-language-or-role') ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="border-right">
                                            <div class="input-box">
                                                <select class="nice_select wide" name="search_category">
                                                    <option value=""><?php echo trans('categories') ?></option>
                                                    <?php foreach ($categories as $category): ?>
                                                        <?php
                                                            $search_cat_label = trans($category->slug);
                                                            if (empty($search_cat_label)) { $search_cat_label = $category->name; }
                                                        ?>
                                                        <option value="<?php echo html_escape($category->id) ?>" <?php if($this->input->get('search_category') == $category->id){echo 'selected';} ?>><?php echo html_escape($search_cat_label) ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="<?php echo html_escape($this->security->get_csrf_token_name());?>" value="<?php echo html_escape($this->security->get_csrf_hash());?>">

                                    <div class="col-md-2 sm-mb-10 sm-mt-10">
                                        <button type="submit" class="text-uppercase btn btn-primary btn-block-xs-only btn-md fs-14 m-auto"><?php echo trans('search') ?></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ------------------------------------------------ GUIDOR --- -->
            <div class="tab-pane fade" id="two" role="tabpanel" aria-labelledby="two-tab">
                <div class="row align-items-center">

                    <div class="col-lg-7 mb-8 mb-lg-0">
                        <div class="g-hero__copy">
                            <h1 class="g-display mb-4">
                                <?php echo lang_value()->site_title_mentor ?>
                            </h1>

                            <p class="g-lead w-lg-80 mb-5">
                                <?php echo lang_value()->site_desc_mentor ?>
                            </p>

                            <!-- PLACEHOLDER COPY -->
                            <div class="row w-lg-90 mb-6">
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <p class="g-band__point text-muted mb-0" style="color:var(--g-muted)"><i class="bi bi-calendar-check"></i> You set your own hours</p>
                                </div>
                                <div class="col-sm-4 mb-3 mb-sm-0">
                                    <p class="g-band__point text-muted mb-0" style="color:var(--g-muted)"><i class="bi bi-wallet2"></i> Paid after each session</p>
                                </div>
                                <div class="col-sm-4">
                                    <p class="g-band__point text-muted mb-0" style="color:var(--g-muted)"><i class="bi bi-shield-check"></i> Verified profile</p>
                                </div>
                            </div>

                            <div class="lift-sm">
                                <a href="<?php echo base_url('register?trial=start') ?>" class="btn btn-lg btn-primary fs-14"><?php echo trans('became-a-member') ?> <i class="pl-1 bi bi-arrow-right"></i></a>
                            </div>

                            <?php if (settings()->trial_days != 0): ?>
                                <p class="text-muted mt-3 fs-12 mb-0"><?php echo trans('start-free-trial.-no-credit-card-required') ?></p>
                            <?php endif ?>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="g-stage">
                            <div class="g-booking">
                                <!-- PLACEHOLDER COPY: the Guidor's side of the same moment -->
                                <div class="g-booking__head">
                                    <div class="g-avatar--ph home-image-md g-booking__face" style="width:44px;height:44px;position:static;opacity:1;transform:none;box-shadow:none;border:0">
                                        <i class="bi bi-calendar3"></i>
                                    </div>
                                    <div class="g-booking__meta">
                                        <p class="g-booking__name">This week</p>
                                        <p class="g-booking__role">3 sessions booked</p>
                                    </div>
                                </div>

                                <div class="g-booking__days">
                                    <span class="g-day is-on">Mon<small>11</small></span>
                                    <span class="g-day">Tue<small>12</small></span>
                                    <span class="g-day is-on">Wed<small>13</small></span>
                                    <span class="g-day">Thu<small>14</small></span>
                                    <span class="g-day is-on">Fri<small>15</small></span>
                                </div>

                                <div class="g-slots">
                                    <span class="g-slot is-taken"><span>Booked</span></span>
                                    <span class="g-slot"><span>Open</span></span>
                                    <span class="g-slot"><span>Open</span></span>
                                </div>

                                <div class="g-booking__foot">
                                    <p class="g-booking__price">Payout this week</p>
                                    <p class="g-booking__price mb-0"><b>৳4,500</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- =========================================================== TRUST ==== -->
<section class="g-stats py-0">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="g-stat" data-g-reveal>
                    <div class="g-stat__n" data-g-count="<?php echo isset($count_mentors) ? (int) $count_mentors : 0 ?>" data-g-suffix="+">0</div>
                    <!-- PLACEHOLDER COPY -->
                    <p class="g-stat__l">Guidors ready to help</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="g-stat" data-g-reveal style="--g-i:1">
                    <div class="g-stat__n" data-g-count="<?php echo isset($count_bookings) ? (int) $count_bookings : 0 ?>" data-g-suffix="+">0</div>
                    <!-- PLACEHOLDER COPY -->
                    <p class="g-stat__l">Sessions completed</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="g-stat" data-g-reveal style="--g-i:2">
                    <div class="g-stat__n" data-g-count="<?php echo isset($count_categories) ? (int) $count_categories : 0 ?>">0</div>
                    <!-- PLACEHOLDER COPY -->
                    <p class="g-stat__l">Areas of expertise</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ================================================ CONNECT LEARN GROW == -->
<?php if (settings()->enable_workflow == 1 && !empty($workflows)): ?>
    <section class="pt-12 pb-12">
        <div class="container">
            <div class="w-md-80 w-lg-50 text-center mx-auto mb-10" data-g-reveal>
                <span class="g-eyebrow mb-3"><?php echo trans('workflow') ?></span>
                <h2 class="g-section-title mt-3 mb-0"><?php echo trans('workflow-title') ?></h2>
            </div>

            <div class="row g-path">
                <svg class="g-path__line" viewBox="0 0 1140 90" preserveAspectRatio="none" aria-hidden="true" focusable="false">
                    <path d="M190,20 C420,90 720,-40 950,20"/>
                </svg>

                <?php $w = 1; foreach ($workflows as $workflow): ?>
                    <div class="col-md-4 mb-8 mb-md-0" data-g-reveal style="--g-i:<?php echo $w ?>">
                        <div class="g-step">
                            <span class="g-step__n"><?php echo str_pad($w, 2, '0', STR_PAD_LEFT) ?></span>
                            <h3 class="g-step__t"><?php echo html_escape($workflow->title) ?></h3>
                            <p class="g-step__d"><?php echo html_escape($workflow->details) ?></p>
                        </div>
                    </div>
                <?php $w++; endforeach ?>
            </div>
        </div>
    </section>
<?php endif; ?>


<!-- ====================================================== CATEGORIES ==== -->
<section class="bg-primary-soft pt-12 pb-12">
    <div class="container">
        <div class="text-center mx-md-auto mb-9" data-g-reveal>
            <span class="g-eyebrow mb-3"><?php echo trans('categories') ?></span>
            <?php if(!empty($categories)): ?>
                <h2 class="g-section-title mt-3 mb-0 w-md-80 mx-auto"><?php echo trans('browse-mentors-by-categories') ?></h2>
            <?php endif; ?>
        </div>

        <div class="row">
            <?php if(empty($categories)): ?>
                <?php $this->load->view('include/not_found_msg'); ?>
            <?php else: ?>
                <?php $c = 1; foreach ($categories as $category): ?>
                    <?php
                        $cat_label = trans($category->slug);
                        if (empty($cat_label)) { $cat_label = $category->name; }
                        $cat_count = (int) count_mentor_by_category($category->id);
                    ?>
                    <div class="col-6 col-md-4 col-lg-3 mb-4" data-g-reveal style="--g-i:<?php echo $c % 4 ?>">
                        <a href="<?php echo base_url('mentors?category='.html_escape($category->slug)); ?>" class="g-cat">
                            <span class="g-cat__icon" aria-hidden="true">
                                <i class="<?php echo html_escape($category->icon) ?>"></i>
                            </span>
                            <span class="g-cat__name" title="<?php echo html_escape($cat_label) ?>"><?php echo html_escape($cat_label) ?></span>
                            <span class="g-cat__n"><?php echo $cat_count ?> <?php echo trans('mentors') ?></span>
                        </a>
                    </div>
                <?php $c++; endforeach ?>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- ================================================= CONNECT LEARN GROW == -->
<section class="g-clg pt-12 pb-12">
    <div class="container">
        <div class="text-center mx-md-auto mb-9" data-g-reveal>
            <span class="g-eyebrow mb-3">How it works</span>
            <h2 class="g-section-title mt-3 mb-0">Connect. Learn. Grow.</h2>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0" data-g-reveal style="--g-i:1">
                <article class="g-clg__card">
                    <div class="g-clg__media">
                        <img src="<?php echo base_url('assets/images/home_connect.webp') ?>" alt="Connect with a Guidor" width="1448" height="1086">
                    </div>
                    <div class="g-clg__body">
                        <span class="g-clg__n">01</span>
                        <h3>Connect</h3>
                        <p>Browse Guidors by skill and experience, then pick the person who fits what you need.</p>
                    </div>
                </article>
            </div>

            <div class="col-md-4 mb-4 mb-md-0" data-g-reveal style="--g-i:2">
                <article class="g-clg__card">
                    <div class="g-clg__media">
                        <img src="<?php echo base_url('assets/images/home_learn.webp') ?>" alt="Learn in a 1:1 session" width="1448" height="1086">
                    </div>
                    <div class="g-clg__body">
                        <span class="g-clg__n">02</span>
                        <h3>Learn</h3>
                        <p>Book a 1:1 session and work through the problem together — questions, feedback, a plan.</p>
                    </div>
                </article>
            </div>

            <div class="col-md-4 mb-0" data-g-reveal style="--g-i:3">
                <article class="g-clg__card">
                    <div class="g-clg__media">
                        <img src="<?php echo base_url('assets/images/home_grow.webp') ?>" alt="Grow in your career" width="1448" height="1086">
                    </div>
                    <div class="g-clg__body">
                        <span class="g-clg__n">03</span>
                        <h3>Grow</h3>
                        <p>Leave with a clearer next step, and come back when you are ready to go further.</p>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>


<!-- ========================================================= GUIDORS ==== -->
<?php if(!empty($mentors)): ?>
<section class="pt-10 pb-10">
    <div class="container">
        <div class="row align-items-end mb-5">
            <div class="col-md-8">
                <h2 class="g-section-title mb-0"><?php echo trans('discover-the-worlds-top-mentors') ?></h2>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <!-- PLACEHOLDER COPY -->
                <a href="<?php echo base_url('mentors') ?>" class="btn btn-sm btn-outline-secondary">See all Guidors <i class="bi bi-arrow-right pl-1"></i></a>
            </div>
        </div>

        <div class="row p-3" data-g-reveal>
            <div class="carousel-4 owl-carousel owl-theme h-100 w-100 navTopRight">
                <?php include APPPATH.'views/include/mentor_item.php'; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<!-- =================================================== BECOME A GUIDOR == -->
<section class="pt-6 pb-12">
    <div class="container">
        <div class="g-band px-5 py-10 px-lg-10" data-g-reveal>

            <svg class="g-band__arc" viewBox="0 0 400 400" aria-hidden="true" focusable="false">
                <path d="M20,200 C20,100 100,20 200,20 C300,20 380,100 380,200"/>
                <path d="M70,220 C70,140 130,70 200,70 C270,70 330,140 330,220"/>
                <path d="M120,240 C120,175 155,120 200,120 C245,120 280,175 280,240"/>
            </svg>

            <div class="row align-items-center position-relative">
                <div class="col-lg-7 mb-6 mb-lg-0">
                    <!-- PLACEHOLDER COPY -->
                    <h2 class="mb-3">Share what you know. Get paid for it.</h2>
                    <p class="fs-16 w-lg-90 mb-5">If you have experience worth passing on, set your hours, set your rate, and start taking sessions. We handle booking and payment.</p>

                    <a href="<?php echo base_url('register?trial=start') ?>" class="g-band__cta">
                        <?php echo trans('became-a-member') ?> <i class="bi bi-arrow-right pl-2"></i>
                    </a>
                </div>

                <div class="col-lg-5">
                    <!-- PLACEHOLDER COPY -->
                    <p class="g-band__point mb-3"><i class="bi bi-check2"></i> Your schedule, your rate</p>
                    <p class="g-band__point mb-3"><i class="bi bi-check2"></i> Paid out after each completed session</p>
                    <p class="g-band__point mb-3"><i class="bi bi-check2"></i> Verified badge once your profile is reviewed</p>
                    <p class="g-band__point mb-0"><i class="bi bi-check2"></i> No cost to list</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================ BLOG ==== -->
<?php if (settings()->enable_blog == 1 && !empty($posts)): ?>
    <section class="bg-lights pt-12 pb-12">
        <div class="container">
            <div class="w-md-80 w-lg-50 text-center mx-auto mb-9" data-g-reveal>
                <span class="g-eyebrow mb-3"><?php echo trans('blogs') ?></span>
                <h2 class="g-section-title mt-3 mb-0"><?php echo trans('learn-more-empower-yourself') ?></h2>
            </div>

            <div class="row">
                <?php $b = 1; foreach ($posts as $post): ?>
                    <?php include 'include/blog_post_item.php'; ?>
                <?php $b++; endforeach ?>
            </div>
        </div>
    </section>
<?php endif ?>


<!-- ==================================================== TESTIMONIALS ==== -->
<?php if (!empty($testimonials)): ?>
    <section class="pt-12 pb-12">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center mb-8" data-g-reveal>
                    <span class="g-eyebrow mb-3"><?php echo trans('testimonia') ?></span>
                    <h2 class="g-section-title mt-3 w-lg-60 mx-auto mb-0"><?php echo trans('testimonial-title') ?> <span class="text-primary"><?php echo settings()->site_name ?></span></h2>
                </div>

                <div class="col-md-12">
                    <div class="testimonial testimonial-carousel owl-carousel owl-theme navTopRight">
                        <?php foreach ($testimonials as $testimonial): ?>
                            <div class="col-6s item mb-5">
                                <div class="card g-sheen shadow-none border-1 h-100 bg-lights mr-2 round-1 rounded-1">
                                    <div class="card-body testimonial-box">
                                        <div class="text-center mb-3">
                                            <div class="text-center pt-3">
                                                <div class="avatar-sm mx-auto" style="background-image: url(<?php echo base_url($testimonial->image) ?>);"></div>
                                                <div class="mt-3">
                                                    <h5 class="mb-0 text-dark"><?php echo html_escape($testimonial->name) ?></h5>
                                                    <p class="text-muted mb-0"><?php echo html_escape($testimonial->designation) ?></p>
                                                </div>
                                            </div>

                                            <?php if (!empty($testimonial->feedback)): ?>
                                                <div class="px-4 pt-3">
                                                    <p class="text-muted font-weight-normal mb-0"><?php echo html_escape($testimonial->feedback) ?></p>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ?>


<!-- ========================================================== BRANDS ==== -->
<?php if (!empty($brands)): ?>
    <section class="bg-grays py-6 border-top">
        <div class="container">
            <div class="brand-carousel-5 owl-carousel owl-theme">
                <?php foreach ($brands as $brand): ?>
                    <div class="item">
                        <a href="<?php echo prep_url($brand->link) ?>">
                            <div class="px-0 px-sm-2 hover-opacity brand_img" style="background-image:url(<?php echo base_url($brand->logo) ?>)"></div>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
<?php endif ?>
