<?php
/**
 * @file
 * Custom teaser and full node display overrides for Blog entry nodes.
 * 
 * Hides the username from $submitted info.
 *
 * @see /themes/adaptivetheme/at_core/templates/node.tpl.php
 * @see /modules/os_features/os_blog
 */
hide($content['comments']);
hide($content['links']);

if ($display_submitted) {
  $submitted = 'Submitted on ' . format_date($node->created, 'short');
}

?>
<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print render($title_prefix); ?>

  <?php if ($title && !$page): ?>
    <header<?php print $header_attributes; ?>>
      <?php if ($title): ?>
        <h1<?php print $title_attributes; ?>>
          <a href="<?php print $node_url; ?>" rel="bookmark"><?php print $title; ?></a>
        </h1>
      <?php endif; ?>
    </header>
  <?php endif; ?>

  <?php if(!empty($user_picture) || $display_submitted): ?>
    <footer<?php print $footer_attributes; ?>>
      <?php print $user_picture; ?>
      <p class="author-datetime"><?php print $submitted; ?></p>
    </footer>
  <?php endif; ?>

  <div<?php print $content_attributes; ?>>
    <?php print render($content); ?>
  </div>

  <?php if ($links = render($content['links'])): ?>
    <nav<?php print $links_attributes; ?>><?php print $links; ?></nav>
  <?php endif; ?>

  <?php print render($content['comments']); ?>

  <?php print render($title_suffix); ?>
</article>

