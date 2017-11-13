<div id="bootstrap-theme">
  <a type="button" data-toggle="modal" data-target="#delete-emergency-contact-<?php print $row->id ?>">
    <i class="fa fa-trash" aria-hidden="true"></i>
  </a>

  <!-- Modal -->
  <div class="modal fade" id="delete-emergency-contact-<?php print $row->id ?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Deletion</h4>
        </div>
        <div class="modal-body">
          <p>This cannot be undone</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link text-uppercase">
            Cancel
          </button>
          <button onclick="Drupal.civihr_theme.deleteEmergencyContact(<?php print $row->id ?>); location.reload();">
            Confirm
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
