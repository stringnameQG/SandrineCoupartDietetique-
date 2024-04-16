function Form() {
  const score = document.getElementById("score").value;
  const comment = document.getElementById("comment").value;
  const recipe = document.getElementById("recipe").value;
  const userId = document.getElementById("userId").value;

  let form = {
      "score" : score,
      "comment" : comment,
      "recipe" : recipe,
      "userId" : userId
  };
  return form;
}

function SendDataView(){
  let form = Form();
    $.ajax({
      type: "POST",
      url: "/php/recette/avisRecette.php",
      data: form,
      timeout: 1500,
      success: function (data) {
        document.querySelector(".form-view").style.display = "none";
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
    
  return false;
}

function BtnSubmit(){
  const btnSubmit = document.querySelector("#Serialisation");
  btnSubmit.addEventListener("click", function(e){
    SendDataView();
  })
}