<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Ajax CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</head>

<body>
    <section style="padding-top:60px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Students <a href="" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#studentModal">Add New Student</a>
                                <a href="" class="btn btn-danger" id="deleteAllSelectedRecord">Delete Selected</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="studentTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="chkCheckAll"/></th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{--@foreach($students as $student)
                                    <tr id="sid{{$student->id}}">
                                        <td><input type="checkbox" name="ids" class="checkBoxClass" value="{{$student->id}}"/></td>
                                        <td>{{$student->firstname}}</td>
                                        <td>{{$student->lastname}}</td>
                                        <td>{{$student->email}}</td>
                                        <td>{{$student->phone}}</td>
                                        <td>
                                            <a href="javascript:void(0)" onclick="editStudent({{$student->id}})" class="btn btn-info">Edit</a>
                                            <a href="javascript:void(0)" onclick="deleteStudent({{$student->id}})" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Student Modal -->
    <div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="studentForm">
                        @csrf
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname">
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="studentEditForm">
                        @csrf
                        <input type="hidden" id="id" name="name" />
                        <div class="mb-3">
                            <label for="firstname2" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstname2">
                        </div>
                        <div class="mb-3">
                            <label for="lastname2" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastname2">
                        </div>
                        <div class="mb-3">
                            <label for="email2" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email2">
                        </div>
                        <div class="mb-3">
                            <label for="phone2" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone2">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $.ajax({
        url: "{{route('student.get')}}",
        type: "GET",
        success: function (response) {
            if (response) {
                for (var i = 0; i < response.length; i++) {
                    $('#studentTable tbody').prepend('<tr id='+'sid'+response[i].id+'><td><input type="checkbox" name="ids" class="checkBoxClass" value='+response[i].id+'></td><td>' + response[i].firstname + '</td><td>' + response[i].lastname + '</td><td>' + response[i].email + '</td><td>' + response[i].phone + '</td><td><a href="javascript:void(0)" onclick=editStudent('+response[i].id+') class="btn btn-info">Edit</a> <a href="javascript:void(0)" onclick=deleteStudent('+response[i].id+') class="btn btn-danger">Delete</a></td></tr>');
                }
            }
        }
    });

    $("#studentForm").submit(function (e) {
        e.preventDefault();
        let firstname = $('#firstname').val();
        let lastname = $('#lastname').val();
        let email = $('#email').val();
        let phone = $('#phone').val();
        let _token = $('input[name=_token]').val();

        $.ajax({
            url: "{{route('student.add')}}",
            type: "POST",
            data: {
                firstname: firstname,
                lastname: lastname,
                email: email,
                phone: phone,
                _token: _token
            },
            success: function (response) {
                if (response) {
                    $('#studentTable tbody').prepend('<tr id='+'sid'+response.id+'><td><input type="checkbox" name="ids" class="checkBoxClass" value='+response.id+'></td><td>' + response.firstname + '</td><td>' + response.lastname + '</td><td>' + response.email + '</td><td>' + response.phone + '</td><td><a href="javascript:void(0)" onclick=editStudent('+response.id+') class="btn btn-info">Edit</a> <a href="javascript:void(0)" onclick=deleteStudent('+response.id+') class="btn btn-danger">Delete</a></td></tr>');
                    $('#studentForm')[0].reset();
                    $('#studentModal').modal('hide');
                }
            }
        });
    });

    function editStudent(id) {
        $.get('/students/' + id, function (student) {
            $('#id').val(student.id);
            $('#firstname2').val(student.firstname);
            $('#lastname2').val(student.lastname);
            $('#email2').val(student.email);
            $('#phone2').val(student.phone);
            $("#studentEditModal").modal('toggle');
        })
    }
    $("#studentEditForm").submit(function (e) {
        e.preventDefault();
        let id=$('#id').val();
        let firstname = $('#firstname2').val();
        let lastname = $('#lastname2').val();
        let email = $('#email2').val();
        let phone = $('#phone2').val();
        let _token = $('input[name=_token]').val();

        $.ajax({
            url: "/student",
            type: "PUT",
            data: {
                id:id,
                firstname: firstname,
                lastname: lastname,
                email: email,
                phone: phone,
                _token: _token
            },
            success: function (response) {
                if (response) {
                    $('#sid'+response.id+' td:nth-child(1)').text(response.firstname);
                    $('#sid'+response.id+' td:nth-child(2)').text(response.lastname);
                    $('#sid'+response.id+' td:nth-child(3)').text(response.email);
                    $('#sid'+response.id+' td:nth-child(4)').text(response.phone);
                    $('#studentEditModal').modal('toggle');
                    $('#studentEditForm')[0].reset();
                }
            }
        });
    });

    function deleteStudent(id){
        if(confirm("Do you really want to delete this record?")){
            $.ajax({
                url:'/student/'+id,
                type:'DELETE',
                data:{
                    _token:$("input[name=_token]").val()
                },
                success:function(response){
                    $("#sid"+id).remove();
                }
            });
        };
    }

    $(function(e){
        $("#chkCheckAll").click(function(){
            $(".checkBoxClass").prop('checked',$(this).prop('checked'));
        });
        $("#deleteAllSelectedRecord").click(function(e){
            e.preventDefault();
            var allids=[];
            $("input:checkbox[name=ids]:checked").each(function(){
                allids.push($(this).val());
            });
            $.ajax({
                url:"{{route('student.deleteSelected')}}",
                type:"DELETE",
                data:{
                    _token:$("input[name=_token]").val(),
                    ids:allids
                },
                success:function(response){
                    $.each(allids,function(key,val){
                        $("#sid"+val).remove();
                    });
                }
            });
        });
    });
</script>

</html>