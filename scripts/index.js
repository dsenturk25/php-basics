
window.onload = () => {
  
  const formTitleInput = document.getElementById("title");
  const authorTitleInput = document.getElementById("author");
  const bodyTitleInput = document.getElementById("body");

  const submitButton = document.getElementById("submit-button");

  submitButton.addEventListener("click", () => {

    if (
      formTitleInput.value &&
      authorTitleInput.value &&
      bodyTitleInput.value
    ) {
      const data = {
        title: formTitleInput.value,
        author: authorTitleInput.value,
        body: bodyTitleInput.value
      };
        
      fetch("./controllers/create_post.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(data => {
          if (data["success"]) {
            return window.location.reload();
          } else return alert("Error occured, please try again.");
        })
    } else {
      alert("Please fill all the required fields in the form!");
    }
  })


  document.addEventListener("click", (event) => {
    if (event.target.classList.contains("each-post-delete-post-button-img")) {
      const id = parseInt(event.target.parentNode.children[1].innerHTML);

      const data = {
        id: id
      };

      fetch("./controllers/delete_post.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
      })
        .then(response => response.json())
        .then(data => {
          if (data["success"]) return alert("Successfully deleted.");
          return alert(data["err"]);
        })
    } else if (event.target.classList.contains("each-post-edit-post-button-img")) {

      const titleInput = document.createElement("input");
      const authorInput = document.createElement("input");
      const bodyInput = document.createElement("textarea");

      const submitButton = document.createElement("div");
      submitButton.classList.add("submit-button");
      submitButton.innerHTML = "Update post";

      const generalDiv = event.target.parentNode.parentNode.parentNode;
      
      const oldTitleDiv = generalDiv.children[0].children[0];
      const oldAuthorDiv = generalDiv.children[1];
      const oldBodyDiv = generalDiv.children[2];

      titleInput.value = oldTitleDiv.innerHTML;
      authorInput.value = oldAuthorDiv.innerHTML;
      bodyInput.value = oldBodyDiv.innerHTML.trim();

      oldTitleDiv.parentNode.insertBefore(titleInput, oldTitleDiv);
      oldTitleDiv.remove();

      oldAuthorDiv.parentNode.appendChild(authorInput);
      oldAuthorDiv.remove();

      oldBodyDiv.parentNode.appendChild(bodyInput);
      oldBodyDiv.remove();

      generalDiv.appendChild(submitButton);
      
      submitButton.addEventListener("click", (event2) => {
        
        const data = {
          id: event.target.parentNode.children[1].innerHTML,
          title: titleInput.value,
          author: authorInput.value,
          body: bodyInput.value
        };

        fetch("./controllers/edit_post.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify(data)
        })
          .then(response => response.json())
          .then(data => {
            if (data["success"]) return window.location.reload();
            return alert(data["err"]);
          })
      })
    }
  })
}
