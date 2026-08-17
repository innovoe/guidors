
<?php if(empty($skills)): ?>
    <option value=""><?php echo trans('no-data-found') ?></option>
<?php else: ?>
    <?php foreach ($skills as $skill): ?>
        <?php
            $selected = '';
            if (!empty($user_skills)) {
                foreach ($user_skills as $user_skill) {
                    if ($skill->id == $user_skill->skill_id) {
                        $selected = 'selected';
                        break;
                    }
                }
            }
        ?>
        <option <?php echo html_escape($selected); ?> value="<?php echo html_escape($skill->id) ?>"><?php echo html_escape($skill->skill) ?></option>
    <?php endforeach ?>
<?php endif; ?>
