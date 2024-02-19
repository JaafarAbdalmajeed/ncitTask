


<div class="modal fade" id="subjectForStudentModel" tabindex="-1" role="dialog" aria-labelledby="subjectForStudentModelLable" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="subjectForStudentModelLable">Subject for Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="studentList2" class="form-control mb-3">
                    <!-- Options for students will be dynamically populated -->
                    <option value="">Choose</option>

                </select>

                <select id="subjectStudentList" class="form-control mb-3">
                    <!-- Options for subjects will be dynamically populated -->
                    <option value="">Choose</option>

                </select>

                <div class="form-group">
                    <input type="number" class="form-control" id="subjectStudentListMarks" name="mark_obtained" placeholder="Grade" min="0">
                </div>


            </div>
            <div class="m-3">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button id="subjectForStudentBtnChangeMark" type="button" class="btn btn-primary">Assign</button>
            </div>
        </div>
    </div>
</div>

