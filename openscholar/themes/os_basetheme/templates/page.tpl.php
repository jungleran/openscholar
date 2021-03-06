<div id="page_wrap" class="page_wrap">
<!--REGION TO HOUSE RESPONSIVE MENU. OTHER CONTENT CAN'T BE PLACED HERE-->
<div class="responive-menu-container clearfix">
  <?php print render($page['responsive_menu']); ?>
</div>

<!--FLEXIBLE ADMIN HEADER FOR USE BY SELECT GROUPS USING OS-->
<?php if ($branding_header = render($page['branding_header'])): ?>
	<div id="branding_header">
		<div  class="branding-container clearfix">
		  <?php print $branding_header; ?>
		</div>
	</div>
<?php endif; ?>

<div id="page" class="container <?php print $classes; ?>">
	<div id="page-wrapper">

		<?php print $messages; ?>

		<?php if (
			$page['header_top'] ||
			$page['header_first'] ||
			$page['header_second'] ||
			$page['header_third'] ||
			$page['header_bottom']
			): ?>
			<!--header regions beg-->
			<header id="header" class="clearfix" role="banner">
			 <div id="header-container">
				 <div id="header-panels" class="at-panel gpanel panel-display three-col clearfix">
					  <?php print render($page['header_top']); ?>
					  <?php print render($page['header_second']); ?>
					  <?php print render($page['header_first']); ?>
					  <?php print render($page['header_third']); ?>
					  <?php print render($page['header_bottom']); ?>
				 </div>
			  </div>
		  </header>
      <!--header regions end-->
		<?php endif; ?>

		<?php if($menu_bar = render($page['menu_bar'])): ?>
		  <!--main menu region beg-->
		  <?php print $menu_bar; ?>
		  <!--main menu region end-->
		<?php endif; ?>

    <?php if($help = render($page['help'])): ?>
		  <!--help region beg-->
		  <?php print $help; ?>
		  <!--help region end-->
		<?php endif; ?>

		<div id="columns" class="clearfix">
			<div class="hg-container">
				<div id="content-column" role="main">
					<div class="content-inner">
					  <?php
					if ($breadcrumb) : print $breadcrumb;
					endif;
 ?>

						<?php if ($is_front || $use_content_regions): ?>
							<?php print render($title_prefix); ?>
              <a name="<?php echo $skip_link; ?>"></a>
							<?php if (!$is_front && $title): ?>
								<header id="main-content-header">
									<a name="<?php echo $skip_link; ?>"></a>
                    <h1 id="page-title"<?php print $attributes; ?>>
                      <?php print $title; ?>
                    </h1>
                </header>
							<?php endif; ?>
							<?php print render($title_suffix); ?>

							<?php if (
								$page['content_top'] ||
								$page['content_first'] ||
								$page['content_second'] ||
								$page['content_bottom']
								): ?>
								<!--front panel regions beg-->
								<div id="content-panels" class="at-panel gpanel panel-display content clearfix">
									<?php print render($page['content_top']); ?>
									<?php print render($page['content_first']); ?>
									<?php print render($page['content_second']); ?>
									<?php print render($page['content_bottom']); ?>
								</div>
								<!--front panel regions end-->
							<?php endif; ?>
						<?php endif; ?>

						<?php if (!$is_front && !$use_content_regions): ?>
							<<?php print $tag; ?> id="main-content">
								<a name="<?php echo $skip_link; ?>"></a>
								<?php print render($title_prefix); ?>
								<?php if ($title || $primary_local_tasks || $secondary_local_tasks || $action_links = render($action_links)): ?>
									<header id="main-content-header">
										<?php if (!$is_front && $title): ?>
											<h1 id="page-title"<?php print $attributes; ?>>
												<?php print $title; ?>
											</h1>
										<?php endif; ?>
										<?php if ($primary_local_tasks || $secondary_local_tasks || $action_links): ?>
											<div id="tasks">
												<?php if ($primary_local_tasks): ?>
													<ul class="tabs primary clearfix"><?php print render($primary_local_tasks); ?></ul>
												<?php endif; ?>
												<?php if ($secondary_local_tasks): ?>
													<ul class="tabs secondary clearfix"><?php print render($secondary_local_tasks); ?></ul>
												<?php endif; ?>
												<?php if ($action_links = render($action_links)): ?>
													<ul class="action-links clearfix"><?php print $action_links; ?></ul>
												<?php endif; ?>
											</div>
										<?php endif; ?>
									</header>
								<?php endif; ?>
								<?php print render($title_suffix); ?>

								<?php if ($content = render($page['content'])): ?>
									<div id="content">
										<?php print $content; ?>
									</div>
								<?php endif; ?>

							</<?php print $tag; ?>><!--main content ends-->
						<?php endif; ?>
					</div>
				</div>

				<?php if ($sidebar_first = render($page['sidebar_first'])): ?>
				  <!--sidebar first region beg-->
				  <?php print $sidebar_first; ?>
				  <!--sidebar first region end-->
        <?php endif; ?>

				<?php if ($sidebar_second = render($page['sidebar_second'])): ?>
				  <!--sidebar second region beg-->
				  <?php print $sidebar_second; ?>
				  <!--sidebar second region end-->
        <?php endif; ?>

			</div>
		</div>
		<!--footer region beg-->
		<footer id="footer" class="clearfix" role="contentinfo">
		<!-- Three column 3x33 Gpanel -->
		<?php if (
			$page['footer_top'] ||
			$page['footer_first'] ||
			$page['footer'] ||
			$page['footer_third'] ||
			$page['footer_bottom']
			): ?>

			<div class="at-panel gpanel panel-display footer clearfix">
				<?php print render($page['footer_top']); ?>
				<?php print render($page['footer_first']); ?>
				<?php print render($page['footer']); ?>
				<?php print render($page['footer_third']); ?>
				<?php print render($page['footer_bottom']); ?>
			</div>

		<!--footer region end-->
  <?php endif; ?>
  <div id="powerby-login">
  	<?php
	if (isset($login_link)) {
		print render($login_link);
	}
 ?>
  	<div id="powered-by"><a href="https://theopenscholar.com">OpenScholar</a></div>
    </div>
  </footer>
  </div>
</div><!--page area ends-->

<div id="extradiv"></div>

<?php if ($branding_footer = render($page['branding_footer'])): ?>
  <!--FLEXIBLE ADMIN FOOTER FOR USE BY SELECT GROUPS USING OS-->
  <div id="branding_footer">
		<div class="branding-container">
	    <?php print $branding_footer; ?>
		</div>
  </div>
<?php endif; ?>

</div><!-- /page_wrap -->

