    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <title>Document</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <nav class="navbar navbar-light bg-light">
                <span class="navbar-brand mb-0 h1">{{Auth::user()->name}}</span>
                <form class="m-0" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="border-0 btn btn-secondary" type="submit">Logout</button>
                </form>
            </nav>


            <button id="show-add" class="btn btn-primary m-3">Add Student</button>
            {{-- <button id="showTopicsBtn" class="btn btn-primary">Display Topics</button> --}}
            <button id="showAddSubjectModalBtn" class="btn btn-primary m-3">Add Subject</button>
            <button id="assignSubjectBtn" class="btn btn-primary m-3">Assign Subject</button>
            <button id="subjectForStudentBtn" class="btn btn-primary m-3">Assign Grade</button>
            <a class="btn btn-success ml-auto" href="/chat/">Chat<i class=" m-2 fa-brands fa-whatsapp"></i>
            </a>





            <!-- Table -->
            <div id="user-table-container"></div>

            <!-- Modal Add Student -->
            @include('admin.models.add_student')
            <!-- Modal Edit Student -->
            @include('admin.models.edit_student')
            <!-- Modal Display Subjects -->
            @include('admin.models.display_subjects')
            <!-- Modal Add Subject -->
            @include('admin.models.add_subject')
            <!-- Modal Assign Subject to Student -->
            @include('admin.models.assignSubjectToStudent')
            <!-- Modal Grade -->
            @include('admin.models.subjectForStudent')

        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <script>
        $(document).ready(function() {

            function loadTableData() {
                    $.ajax({
                        url: '{{route('student.index')}}',
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            var users = response;
                            var table = '<table class="table bg-dark text-white">' +
                                            '<thead class="thead-dark">' +
                                                '<tr>' +
                                                    '<th>Name</th>' +
                                                    '<th>Email</th>' +
                                                    '<th>Edit</th>' +
                                                    '<th>Delete</th>' +
                                                '</tr>' +
                                            '</thead>' +
                                            '<tbody>';
                            $.each(users, function(index, user) {
                                table += '<tr>' +
                                            '<td>' + user.name + '</td>' +
                                            '<td>' + user.email + '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-primary edit-btn" data-id="' + user.id + '" data-name="' + user.name + '" data-email="' + user.email + '">Edit</button>' +
                                            '</td>' +
                                            '<td>' +
                                                '<button class="btn btn-danger delete-btn" data-id="' + user.id + '">Delete</button>' +
                                            '</td>' +

                                        '</tr>';
                            });
                            table += '</tbody></table>';
                            $('#user-table-container').html(table);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                }



            $('#show-add').click(function() {
                $('#addStudentModal').modal('show');
                $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#passwordRepeat').val('');

            });

            $('#addStudentModal .close').click(function() {
                $('#addStudentModal').modal('hide');
            });

            $('#form-add').submit(function(e) {
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var passwordRepeat = $('#passwordRepeat').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('student.store') }}",
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        passwordRepeat: passwordRepeat,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal("Success", "Student added successfully", "success");
                        $('#addStudentModal').modal('hide');
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#passwordRepeat').val('');
                        loadTableData()
                    },
                    error: function(xhr, status, error) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '\n'; // Concatenate error messages
                        });
                        swal("Error", errorMessage, "error"); // Display error message
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');
                        $('#passwordRepeat').val('');
                    }
                });
            });
            loadTableData()



            // Show edit modal and populate inputs with current student's details
            $(document).on('click', '.edit-btn', function() {
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
                var newAccountState = $('#edit_account_state').is(":checked") ? 1 : 0; // Check if checkbox is checked


                $.ajax({
                    type: "PUT",
                    url: "/student/" + studentId,
                    data: {
                        name: newName,
                        email: newEmail,
                        state: newAccountState,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        swal("Success", "Student updated successfully", "success");
                        $('#editStudentModal').modal('hide');
                        $('#edit_name').val('');
                        $('#edit_email').val('');

                        loadTableData()
                    },
                    error: function(xhr, status, error) {
                        // Handle validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value + '\n'; // Concatenate error messages
                        });
                        swal("Error", errorMessage, "error"); // Display error message

                    }
                });
            });


            // Handle delete button click
            $(document).on('click', '.delete-btn', function() {
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
                                loadTableData()
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
                        swal("Success", response.message, "success");
                        $('#subjectMark').val('');
                        $('#subjectName').val('');
                        // You may want to update the subjects list without reloading the page
                    },
                    error: function(xhr, status, error) {
                        // Show error message if available, else show a generic error message
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.errors ? Object.values(xhr.responseJSON.errors).join("\n") : "An error occurred while adding the subject";
                        swal("Error", errorMessage, "error");
                        $('#subjectMark').val('');
                        $('#subjectName').val('');
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
                // var mark = $('#markList').val();

                // Send AJAX request to assign subject to student
                $.ajax({
                    type: "POST",
                    url: "{{ route('assign.subject.to.student') }}",
                    data: {
                        user_id: studentId,
                        subject_id: subjectId,
                        // mark_obtained: mark, // Include the selected mark
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
                        // $('#subjectList').empty();
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
                        // $('#studentList').empty();
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

            $('#subjectForStudentBtn').click(function() {
                // Show the assign subject modal
                $('#subjectForStudentModel').modal('show');
                // Load subjects and students data
                // loadSubjects();
                loadStudents2();
            });



            // Event listener for when a student is selected
            $('#studentList2').change(function() {
                var studentId = $(this).val();
                if(studentId) {
                    // Fetch grades for the selected student
                    fetchGrades(studentId);

                }
            });


            $('#subjectStudentList').change(function() {
                var studentId = $('#studentList2').val();
                var subjectId = $(this).val();
                if(studentId && subjectId) {
                    // Fetch grades for the selected student
                    fetchMark(studentId, subjectId);
                }
            });


            function resetSelectElements() {
                $('#studentList2').empty().append($('<option>', {
                    value: '',
                    text: 'Choose'
                }));

                $('#subjectStudentList').empty().append($('<option>', {
                    value: '',
                    text: 'Choose'
                }));

                $('#subjectList').empty().append($('<option>', {
                    value: '',
                    text: 'Choose'
                }));

                $('#studentList').empty().append($('<option>', {
                    value: '',
                    text: 'Choose'
                }));

                $('#subjectStudentListMarks').val("");

            }

            $('#subjectForStudentModel').on('hidden.bs.modal', function (e) {
                resetSelectElements();
            });

            $('#assignSubjectModal').on('hidden.bs.modal', function (e) {
                resetSelectElements();
            });




            function loadStudents2() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('fetch.students2') }}",
                    success: function(response) {
                        // Populate the student list in the modal
                        $.each(response, function(index, student) {
                            $('#studentList2').append($('<option>', {
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

            function fetchGrades(studentId) {
                $.ajax({
                    type: "GET",
                    url: "/fetch-student-grades/" + studentId,

                    success: function(response) {

                        $.each(response, function(index, grade) {
                            $('#subjectStudentList').append($('<option>', {
                                value: grade.id,
                                text: grade.subject.name
                            }));
                        });

                    },
                    error: function(xhr, status, error) {
                        swal("Error", "An error occurred while loading grades", "error");
                    }
                });
            }


            function fetchMark(studentId, subjectId) {
                $.ajax({
                    type: "GET",
                    url: "{{route('fetchMark')}}",
                    data: {
                        studentId: studentId,
                        subjectId: subjectId
                    },
                    success: function(response) {
                        $('#subjectStudentListMarks').val(""); // Clear the input field before populating
                        $('#subjectStudentListMarks').val(response.mark_obtained); // Set the value of the input field with the obtained grade

                    },
                    error: function(xhr, status, error) {
                        $('#subjectStudentListMarks').val("");
                        swal("Error", "An error occurred while loading grades", "error");
                    }
                });
            }



            $('#subjectForStudentBtnChangeMark').click(function() {
                var studentId = $('#studentList2').val();
                var subjectId = $('#subjectStudentList').val();
                var mark_obtained = $('#subjectStudentListMarks').val();

                // Make sure all fields are filled
                if (studentId && subjectId && mark_obtained) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('assign.mark') }}", // Replace with your route for assigning mark
                        data: {
                            student_id: studentId,
                            subject_id: subjectId,
                            mark_obtained: mark_obtained,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            // Show success message
                            alert(response)
                            swal("Success", "Mark assigned successfully", "success");
                            // Close the modal
                            $('#subjectForStudentModel').modal('hide');
                            $('#subjectStudentListMarks').val(""); // Clear the input field before populating

                        },
                        error: function(xhr, status, error) {
                            // Show error message
                            swal("Error", "An error occurred while assigning mark", "error");
                            $('#subjectStudentListMarks').val(""); // Clear the input field before populating

                        }
                    });
                } else {
                    // Show error message if any field is empty
                    swal("Error", "Please fill all fields", "error");
                }
            });
        });
    </script>
    </body>
    </html>
