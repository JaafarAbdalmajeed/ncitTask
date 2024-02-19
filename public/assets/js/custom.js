$(document).ready(function() {
    $('#show-add').click(function() {
        $('#addStudentModal').modal('show');
    });

    $('#addStudentModal .close').click(function() {
        $('#addStudentModal').modal('hide');
    });

    $('#form-add').submit(function(e) {
        e.preventDefault();
        var name = $('#name').val();
        var email = $('#email').val();
        var password = $('#password').val();

        $.ajax({
            type: "POST",
            url: "{{ route('student.store') }}",
            data: {
                name: name,
                email: email,
                password: password,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                swal("Success", "Student added successfully", "success");
                $('#addStudentModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while adding the student", "error");
            }
        });
    });


    // Show edit modal and populate inputs with current student's details
    $('.edit-btn').click(function() {
        var studentId = $(this).data('id');
        var studentName = $(this).data('name');
        var studentEmail = $(this).data('email');

        $('#edit_student_id').val(studentId);
        $('#edit_name').val(studentName);
        $('#edit_email').val(studentEmail);

        $('#editStudentModal').modal('show');
    });

    // Handle form submission for editing student
    $('#form-edit').submit(function(e) {
        e.preventDefault();
        var studentId = $('#edit_student_id').val();
        var newName = $('#edit_name').val();
        var newEmail = $('#edit_email').val();

        $.ajax({
            type: "PUT",
            url: "/student/" + studentId,
            data: {
                name: newName,
                email: newEmail,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                swal("Success", "Student updated successfully", "success");
                $('#editStudentModal').modal('hide');
                window.location.reload();
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while updating the student", "error");
            }
        });
    });


    // Handle delete button click
    $('.delete-btn').click(function() {
        var studentId = $(this).data('id');

        // Confirm deletion
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this student!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                // Send AJAX request to delete student
                $.ajax({
                    type: "DELETE",
                    url: "/student/" + studentId,
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal("Success", "Student deleted successfully", "success");
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        swal("Error", "An error occurred while deleting the student", "error");
                    }
                });
            }
        });
    });
    // Handle click event of the "Display Topics" button
    $('#showTopicsBtn').click(function() {
        // Send AJAX request to fetch topics from the server
        $.ajax({
            type: "GET",
            url: "{{ route('subject.index') }}",
            success: function(response) {
                // Clear previous list of topics
                $('#topicsList').empty();

                // Populate modal with the list of topics
                response.forEach(function(topic) {
                    $('#topicsList').append('<li class="list-group-item">' + topic.name + ' - Mark: ' + topic.mark + '</li>');
                });

                // Show the modal
                $('#displayTopicsModal').modal('show');
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching topics", "error");
            }
        });
    });


    // Handle click event of the "Add Subject" button
    $('#showAddSubjectModalBtn').click(function() {
        // Show the modal
        $('#addSubjectModal').modal('show');
    });

    // Handle form submission
    $('#addSubjectForm').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();

        // Send AJAX request to add the subject
        $.ajax({
            type: "POST",
            url: "{{ route('subject.store') }}",
            data: formData,
            success: function(response) {
                // Show success message
                swal("Success", "Subject added successfully", "success");
                // Reload the page to refresh the subjects list
                window.location.reload();
            },
            error: function(xhr, status, error) {
                // Show error message
                swal("Error", "An error occurred while adding the subject", "error");
            }
        });
    });


    // Handle click event of the "Assign Subject" button
    $('#assignSubjectBtn').click(function() {
        // Show the assign subject modal
        $('#assignSubjectModal').modal('show');

        // Load subjects and students data
        loadSubjects();
        loadStudents();
    });

    // Handle click event of the "Assign" button inside the modal
    $('#assignSubjectToStudentBtn').click(function() {
        // Get the selected subject, student, and mark
        var subjectId = $('#subjectList').val();
        var studentId = $('#studentList').val();
        var mark = $('#markList').val();

        // Send AJAX request to assign subject to student
        $.ajax({
            type: "POST",
            url: "{{ route('assign.subject.to.student') }}",
            data: {
                user_id: studentId,
                subject_id: subjectId,
                mark_obtained: mark, // Include the selected mark
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                // Show success message
                swal("Success", "Subject assigned to student successfully", "success");
                // Close the modal
                $('#assignSubjectModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Show error message
                swal("Error", "An error occurred while assigning subject to student", "error");
            }
        });
    });

    // Function to load subjects data
    function loadSubjects() {
        // Send AJAX request to fetch subjects data
        $.ajax({
            type: "GET",
            url: "{{ route('fetch.subjects') }}",
            success: function(response) {
                // Populate the subject list in the modal
                $('#subjectList').empty();
                $.each(response, function(index, subject) {
                    $('#subjectList').append($('<option>', {
                        value: subject.id,
                        text: subject.name
                    }));
                });
            },
            error: function(xhr, status, error) {
                // Show error message
                swal("Error", "An error occurred while loading subjects", "error");
            }
        });
    }

    // Function to load students data
    function loadStudents() {
        // Send AJAX request to fetch students data
        $.ajax({
            type: "GET",
            url: "{{ route('fetch.students') }}",
            success: function(response) {
                // Populate the student list in the modal
                $('#studentList').empty();
                $.each(response, function(index, student) {
                    $('#studentList').append($('<option>', {
                        value: student.id,
                        text: student.name
                    }));
                });
            },
            error: function(xhr, status, error) {
                // Show error message
                swal("Error", "An error occurred while loading students", "error");
            }
        });
    }
});
