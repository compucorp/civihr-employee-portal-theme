<div>
  <a
    class="pointer"
    type="button"
    data-toggle="modal"
    data-target="#delete-dependents-<?php print $row->id ?>">
    <i class="fa fa-trash text-danger" aria-hidden="true"></i>
  </a>

  <!-- Modal -->
  <div class="modal fade" id="delete-dependents-<?php print $row->id ?>" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
          </button>
          <h4 class="modal-title">Confirm Deletion</h4>
        </div>
        <div class="modal-body">
          Are you sure you want to remove this dependent?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link text-uppercase" data-dismiss="modal">
            Cancel
          </button>
          <button
            class="btn btn-danger text-uppercase"
            onclick="Drupal.civihr_theme.deleteEmergencyContact(<?php print $row->id ?>); location.reload();">
            Confirm
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
