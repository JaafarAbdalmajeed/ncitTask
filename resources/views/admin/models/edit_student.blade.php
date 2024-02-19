<div class="modal fade" id="editStudentModal" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form inside modal -->
                <form id="form-edit">
                    @csrf
                    @method('PUT') <!-- Use PUT method for updating -->
                    <input type="hidden" id="edit_student_id" name="id">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email address</label>
                        <input type="email" class="form-control" id="edit_email" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" id="edit_account_state" name="account_state">
                        <label class="form-check-label" for="edit_account_state">Account State</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

