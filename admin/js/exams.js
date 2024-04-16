let questionCount = 0;

function createQuestionDiv() {

    questionCount++;
    let html = ` 
        <div class="card card-outline card-info single-question" id="question-${questionCount}">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="title">Question ${questionCount}</label>
                            <input type="text" class="form-control title" id="title" placeholder="Enter question" required />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="option1">Option 1</label>
                            <input class="form-control option1" id="option1" placeholder="Option 1" required></input>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="option2">Option 2</label>
                            <input type="text" class="form-control option2" id="option2" placeholder="Option 2" required />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="option3">Option 3</label>
                            <input type="text" class="form-control option3" id="option3" placeholder="Option 3" required />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="option4">Option 4</label>
                            <input type="text" class="form-control option4" id="option4" placeholder="Option 4" required />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="correctOptionNumber">Correct Option Number</label>
                            <select id="correctOptionNumber" class="custom-select correctOptionNumber">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="removeQuestion(${questionCount})">X</button>
                    </div>
                </div>
            </div>
        </div>
    
`;
    $('#questions').append(html);
}

function removeQuestion(divId) {
    $(`#question-${divId}`).remove();
}

function createExam() {
    let questions = $('.single-question');
    console.log(questions);
   if (questions.length == 0)
    {
        alert('There must be at least 1 question in the exam!');
        return;
    }
    
    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();
    
    let formData = new FormData();
    formData.append('name', $('#name').val());
    formData.append('description', $('#description').val());
    formData.append('date', $('#date').val());
    formData.append('time', $('#time').val());
    formData.append('subject', $('#subject').val());

    for (let i = 0; i < questions.length; i++) {
        formData.append('title[]', $(questions[i]).find('.title').val());
        formData.append('option1[]', $(questions[i]).find('.option1').val());
        formData.append('option2[]', $(questions[i]).find('.option2').val());
        formData.append('option3[]', $(questions[i]).find('.option3').val());
        formData.append('option4[]', $(questions[i]).find('.option4').val());
        formData.append('correctOptionNumber[]', $(questions[i]).find('.correctOptionNumber').val());
    }

    $.ajax({
        method: 'POST',
        url: '../exams/create.php',
        contentType: false,
        processData: false,
        data: formData,
        success: (response) => {
            if (response.status) {
                $('#btn-submit-text').hide();
                $('#btn-submit-text-saved').show();
                $('#btn-submit-spinner').hide();

                setTimeout(() => window.location.href = '../exams', 1000);
            }
        },
        error: (reason) => {
            console.log(reason);
        }
    });
}

function editExam(id) {

    let questions = $('.single-question');
    if (questions.length == 0)
    {
        alert('There must be at least 1 question in the exam!');
        return;
    }

    $('#btn-submit').attr('disabled', '');

    $('#btn-submit-text').hide();
    $('#btn-submit-text-saved').hide();
    $('#btn-submit-spinner').show();

    let formData = new FormData();
    formData.append('id', id);
    formData.append('name', $('#name').val());
    formData.append('description', $('#description').val());
    formData.append('date', $('#date').val());
    formData.append('time', $('#time').val());
    formData.append('subject', $('#subject').val());


    for (let i = 0; i < questions.length; i++) {
        formData.append('title[]', $(questions[i]).find('.title').val());
        formData.append('option1[]', $(questions[i]).find('.option1').val());
        formData.append('option2[]', $(questions[i]).find('.option2').val());
        formData.append('option3[]', $(questions[i]).find('.option3').val());
        formData.append('option4[]', $(questions[i]).find('.option4').val());
        formData.append('correctOptionNumber[]', $(questions[i]).find('.correctOptionNumber').val());
    }

    $.ajax({
        method: 'POST',
        url: '../exams/edit.php',
        contentType: false,
        processData: false,
        data: formData,
        success: (response) => {
            if (response.status) {
                $('#btn-submit-text').hide();
                $('#btn-submit-text-saved').show();
                $('#btn-submit-spinner').hide();

                setTimeout(() => window.location.href = '../exams', 1000);
            }
        }
    });

    return false;
}

function showDeleteExamConfirmation(id) {
    $('#btn-yes').attr('data-id', id);
    $('#modal-delete').modal('show');
}

function deleteExam() {
    let id = $('#btn-yes').attr('data-id');
    if (id == null)
        return;

    window.location.href = '../exams/delete.php?id=' + id;
}