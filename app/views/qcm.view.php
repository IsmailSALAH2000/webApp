<!DOCTYPE html>
<html>
<head>
  <title>QCM</title>
  <style>
    .question {
      margin-bottom: 10px;
      font-weight: bold;
    }
    .choice {
      margin-left: 20px;
    }
    .correct {
      color: green;
    }
    .incorrect {
      color: red;
    }
  </style>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $.ajax({
        url: 'qcm_controller.php',
        method: 'get',
        dataType: 'json',
        success: function(data) {
          displayQuestions(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.error('Erreur lors de la récupération des données du QCM : ' + textStatus + ' - ' + errorThrown);
        }
      });
    });

    function displayQuestions(questions) {
      var container = $('#qcm_container');
      $.each(questions, function(index, question) {
        var question_el = $('<div>').addClass('question').text('Question : ' + question.text);
        container.append(question_el);
        $.each(question.choices, function(index, choice) {
          var choice_el = $('<div>').addClass('choice').text('- ' + choice.text);
          if (choice.correct === 'true') {
            choice_el.addClass('correct');
          } else {
            choice_el.addClass('incorrect');
          }
          container.append(choice_el);
        });
      });
    }
  </script>
</head>
<body>
  <h1>QCM</h1>
  <div id="qcm_container"></div>
</body>
</html>
