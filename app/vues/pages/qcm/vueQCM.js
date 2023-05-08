$(document).ready(function() {
    var questionIndex = 0;
    var reponseIndex = 0;

    // Ajouter une nouvelle question
    $("#addQuestion").click(function() {
        questionIndex++;
        var newQuestion = '<div class="question"><label name>Question ' + questionIndex + '</label><input type="text" name="question' + questionIndex + '"><button type="button" class="addReponse">Ajouter une réponse</button><div class="reponses"></div></div>';
        $("#editQCM").append(newQuestion);
        reponseIndex=0;
    });

    // Ajouter une nouvelle réponse
    $("#editQCM").on("click", ".addReponse", function() {
        reponseIndex++;
        var parentQuestion = $(this).closest(".question");
        var newReponse = '<div class="reponse"><label>Réponse: </label><input type="text" name="reponse' + questionIndex + reponseIndex +'"><input type="radio" class="checkbox"name="correction' + questionIndex +reponseIndex + '" value="true"> Vrai <input type="radio" class="checkbox"name="correction' + questionIndex + reponseIndex + '" value="false" checked="true"> Faux </div>';
        $(parentQuestion).find(".reponses").append(newReponse);
    });

});