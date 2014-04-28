  <?php do_action('sidebar-begin'); ?>
    <?php if ( ! dynamic_sidebar('sidebar')) : ?>
      <!-- Sidebar Widget (Default)-->
      <div class="sidebar-widget">
        <h4 class="page-header subheading">Sidebar Widget</h4>
        <p>Go to Appearance > Widget to add sidebar widget into this area.</p>
      </div>
    <?php endif; ?>
  <?php do_action('sidebar-end'); ?>