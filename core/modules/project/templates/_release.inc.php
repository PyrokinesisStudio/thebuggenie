<li class="release_item rounded_box invisible <?php if ($build->isActive()) echo 'active'; ?>" style="line-height: 1.3;">
    <div class="button-group">
        <?php if ($build->isActive()): ?>
            <?php if ($build->hasDownload()): ?>
                <?php echo ($build->hasFile()) ? link_tag(make_url('downloadfile', array('id' => $build->getFile()->getID())), image_tag('icon_download.png').__('Download'), array('class' => 'button button-orange')) : link_tag($build->getFileURL(), image_tag('icon_download.png').__('Download'), array('class' => 'button button-orange')); ?>
            <?php endif; ?>
            <?php echo javascript_link_tag(__('Report an issue'), array('onclick' => "TBG.Main.Helpers.Backdrop.show('".make_url('get_partial_for_backdrop', array('key' => 'reportissue', 'project_id' => $build->getProject()->getId(), 'build_id' => $build->getID()))."');", 'class' => 'button button-green')); ?>
        <?php else: ?>
            <?php if ($build->hasDownload()): ?>
                <?php if (!$build->isReleased()): ?>
                    <div class="button button-silver disabled" title="<?php echo __('This release is no longer available for download'); ?>"><?php echo __('Download'); ?></div>
                <?php else: ?>
                    <?php echo ($build->hasFile()) ? link_tag(make_url('downloadfile', array('id' => $build->getFile()->getID())), image_tag('icon_download.png').__('Download'), array('class' => 'button button-orange')) : link_tag($build->getFileURL(), image_tag('icon_download.png').__('Download'), array('class' => 'button button-orange')); ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php echo image_tag('icon_build_large.png', array('class' => 'release_icon')); ?><span class="release_name"><?php echo $build->getName(); ?></span><span class="release_version"><?php echo $build->getVersion(); ?></span>
    <span class="release_date" id="build_<?php echo $build->getID(); ?>_release_date">
    <?php if ($build->isReleased()): ?>
        <?php echo __('Released %release_date', array('%release_date' => tbg_formatTime($build->getReleaseDate(), 7, true, true))); ?>
    <?php else: ?>
        <?php echo __('Not released yet'); ?>
    <?php endif; ?>
    </span>
</li>
