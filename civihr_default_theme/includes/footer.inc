<footer id="footer" class="footer" role="footer">
  <div class="container">
    <div class="text-center">
      Powered by CiviHR <?php print get_civihr_version(); ?>.
      CiviHR is openly available under the <a target="_blank" href="http://www.gnu.org/licenses/agpl-3.0.html">GNU AGPL License</a> and can be downloaded from the <a target="_blank" href="https://civihr.org">Project website</a>&nbsp;.
      <div class="footer-logo">
        <i class="icon-logo-full"></i>
      </div>
      <?php if ($copyright): ?>
        <div class="copyright"><?php print $copyright; ?></div>
      <?php endif; ?>
    </div>
  </div>
</footer>
