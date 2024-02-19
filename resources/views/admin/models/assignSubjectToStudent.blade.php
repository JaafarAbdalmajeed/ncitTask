<div class="modal fade" id="assignSubjectModal" tabindex="-1" role="dialog" aria-labelledby="assignSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignSubjectModalLabel">Assign Subject to Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Subject and Student lists go here -->
                <select id="subjectList" class="form-control mb-3">
                    <!-- Options for subjects will be dynamically populated -->
                    <option value="">Choose</option>
                </select>
                <select id="studentList" class="form-control mb-3">
                    <!-- Options for students will be dynamically populated -->
                    <option value="">Choose</option>
                </select>

            </div>
            <div class="m-3">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button id="assignSubjectToStudentBtn" type="button" class="btn btn-primary">Assign</button>
            </div>
        </div>
    </div>
</div>
