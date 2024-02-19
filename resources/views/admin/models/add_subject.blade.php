            <div class="modal fade" id="addSubjectModal" tabindex="-1" role="dialog" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addSubjectModalLabel">Add Subject</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="addSubjectForm">
                                @csrf
                                <div class="form-group">
                                    <label for="subjectName">Name</label>
                                    <input type="text" class="form-control" id="subjectName" name="name" placeholder="Enter subject name">
                                </div>
                                <div class="form-group">
                                    <label for="subjectMark">Mark</label>
                                    <input type="text" class="form-control" id="subjectMark" name="mark" placeholder="Enter subject mark">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Subject</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
