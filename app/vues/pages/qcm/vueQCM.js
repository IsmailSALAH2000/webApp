$(document).ready(function() {
    var questionIndex = 0;
    var reponseIndex = 0;

    // Ajouter une nouvelle question
    $("#addQuestion").click(function() {
        questionIndex++;
        var newQuestion = '<div class="question"><label name>Question ' + questionIndex + '</label><input type="text" name="question' + questionIndex + '"><button type="button" class="removeQuestion">Supprimer la question</button><button type="button" class="addReponse">Ajouter une réponse</button><div class="reponses"></div></div>';
        $("#editQCM").append(newQuestion);
        reponseIndex=0;
    });

    // Supprimer une question
    $("#editQCM").on("click", ".removeQuestion", function() {
        $(this).closest(".question").remove();
        questionIndex--;
    });

    // Ajouter une nouvelle réponse
    $("#editQCM").on("click", ".addReponse", function() {
        reponseIndex++;
        var parentQuestion = $(this).closest(".question");
        var newReponse = '<div class="reponse"><label>Réponse ' + reponseIndex + '</label><input type="text" name="reponse' + questionIndex + '"><input type="checkbox" name="correction' + reponseIndex + '" value="true"> Vrai <input type="checkbox" name="correction' + reponseIndex + '" value="false"> Faux <button type="button" class="removeReponse">Supprimer la réponse</button></div>';
        $(parentQuestion).find(".reponses").append(newReponse);
    });

    // Supprimer une réponse
    $("#editQCM").on("click", ".removeReponse", function() {
        $(this).closest(".reponse").remove();
        reponseIndex--;
    });


});