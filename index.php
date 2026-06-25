<?php
require 'Student.php';
$student = new Student();

if (isset($_POST['action'])) {

    if ($_POST['action'] == 'fetch') {
        $data = $student->all();
        foreach ($data as $row) {
            echo "
            <tr>
                <td>{$row['fullname']}</td>
                <td>{$row['course']}</td>
                <td>
                    <button class='btn btn-sm btn-warning edit'
                        data-id='{$row['id']}'
                        data-name='{$row['fullname']}'
                        data-course='{$row['course']}'>Edit</button>
                    <button class='btn btn-sm btn-danger delete'
                        data-id='{$row['id']}'>Delete</button>
                </td>
            </tr>";
        }
        exit;
    }

    if ($_POST['action'] == 'store') {
        $student->store($_POST['fullname'], $_POST['course']);
        exit;
    }

    if ($_POST['action'] == 'update') {
        $student->update($_POST['id'], $_POST['fullname'], $_POST['course']);
        exit;
    }

    if ($_POST['action'] == 'delete') {
        $student->delete($_POST['id']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h3 class="mb-3">Student CRUD (PHP OOP + AJAX + BOOTSTRAP)</h3>

<form id="studentForm" class="mb-4">
    <input type="hidden" id="id">

    <div class="mb-2">
        <input type="text" id="fullname" class="form-control" placeholder="Full Name" required>
    </div>

    <div class="mb-2">
        <input type="text" id="course" class="form-control" placeholder="Course" required>
    </div>

    <button class="btn btn-primary">Save</button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Course</th>
            <th width="150">Action</th>
        </tr>
    </thead>
    <tbody id="studentData"></tbody>
</table>

<script>
const base_url = '';
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>

function loadData() {
    $.ajax({
        url: base_url + 'index.php',
        type: 'POST',
        data: {
            action: 'fetch'
        },
        success: function (result) {
            $('#studentData').html(result);
        }
    });
}
loadData();

$('#studentForm').on('submit', function (e) {
    e.preventDefault();

    let action = $('#id').val() ? 'update' : 'store';

    $.ajax({
        url: base_url + 'index.php',
        type: 'POST',
        data: {
            action: action,
            id: $('#id').val(),
            fullname: $('#fullname').val(),
            course: $('#course').val()
        },
        success: function () {
            $('#studentForm')[0].reset();
            $('#id').val('');
            loadData();
        }
    });
});

$(document).on('click', '.edit', function () {
    $('#id').val($(this).data('id'));
    $('#fullname').val($(this).data('name'));
    $('#course').val($(this).data('course'));
});

$(document).on('click', '.delete', function () {
    if (confirm('Delete this record?')) {
        $.ajax({
            url: base_url + 'index.php',
            type: 'POST',
            data: {
                action: 'delete',
                id: $(this).data('id')
            },
            success: function () {
                loadData();
            }
        });
    }
});
</script>

</body>
</html>