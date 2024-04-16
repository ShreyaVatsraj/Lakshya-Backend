function addStudent() {
    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();

    let formData = new FormData();
    formData.append('username', $('#username').val());
    formData.append('password', $('#password').val());
    formData.append('name', $('#name').val());
    formData.append('pnumber', $('#pnumber').val());
    formData.append('gender', $('#gender').val());
    formData.append('user-id', $('#user-id').val());

    $.ajax({
        method: 'POST',
        url: '../students/add.php',
        contentType: false,
        processData: false,
        data: formData,
        success: (response) => {
            if (response.status) {
                $('#btn-submit-text').hide();
                $('#btn-submit-text-saved').show();
                $('#btn-submit-spinner').hide();

                setTimeout(() => window.location.href = '../students', 1000);
            }
        },
        error: (reason) => {
            console.log(reason);
        }
    });

    return false;
}

function editStudent(id) {
    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();

    let formData = new FormData();
    formData.append('id', id);
    formData.append('name', $('#name').val());
    formData.append('pnumber', $('#pnumber').val());
    formData.append('gender', $('#gender').val());

    $.ajax({
        method: 'POST',
        url: '../students/edit.php',
        contentType: false,
        processData: false,
        data: formData,
        success: (response) => {
            if (response.status) {
                $('#btn-submit-text').hide();
                $('#btn-submit-text-saved').show();
                $('#btn-submit-spinner').hide();

                setTimeout(() => window.location.href = '../students', 1000);
            }
        }
    });

    return false;
}

function showDeleteStudentConfirmation(id) {
    $('#btn-yes').attr('data-id', id);
    $('#modal-delete').modal('show');
}

function deleteStudent() {
    let id = $('#btn-yes').attr('data-id');
    if (id == null)
        return;

    window.location.href = '../students/delete.php?id=' + id;
}