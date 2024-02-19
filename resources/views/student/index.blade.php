<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>

    <div class="container py-5">
        <nav class="navbar navbar-light bg-light">
            <span class="navbar-brand mb-0 h1"></span>
            <form class="m-0" action="{{ route('logout') }}" method="post">
                @csrf
                <button class="border-0 btn btn-secondary" type="submit">Logout</button>
            </form>
            {{-- <a class="btn btn-success ml-auto chatAdmin" href="/chat/1">Admin</a> --}}

        </nav>

        <div class="row">
            <div class="col-lg-3 mt-2 ">
                <div class="card mb-4 text-white bg-info">
                    <div class="card-body text-center ">
                        <h5 class="my-3">{{$user->name}}</h5>
                        <p class=" mb-1">{{$user->email}}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 mt-2">
                <a class="btn btn-success ml-auto m-2" href="/chat/">Chat <i class="m-2 fa-brands fa-whatsapp"></i></a>

                <table class="table bg-dark text-white">
                    <thead class="thead-dark">
                        <tr>
                            <th>Subject</th>
                            <th>Mark subject</th>
                            <th>Mark obtained</th>

                        </tr>
                    </thead>
                    <tbody>
                        @if ($grades)
                        @foreach ($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject->name }}</td>
                                <td>{{ $grade->subject->mark }}</td>
                                <td>{{ $grade->mark_obtained}}</td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="3">No grades found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Display Student For Subject Model -->
        @include('student.model.displayStudent')
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){

            function fetchAdminChat(user_id) {
                $.get("/chat/admin/" + user_id, function (data, textStatus, jqXHR) {
                    // Handle the response data
                }, "dataType");
            }

            $(".chatAdmin").click(function(event) {
            var user_id = $(this).data("id");
            fetchAdminChat(user_id);
        });



            $('.show-students').click(function (e) {
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "/students/"+id,
                    success: function (response) {
                        $('#studentsList').empty();
                        response.forEach(function(student) {
                            $('#studentsList').append('<li class="list-group-item d-flex align-items-center" data-id="' + student.user.id + '">' +
                                '<span class="mr-auto">' + student.user.name + '</span>' +
                                '<a class="btn btn-success ml-auto" href="/chat/' + student.user.id + '">Chat</a>' +
                            '</li>');
                            });
                        $('#displayStudentsSubjectModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
