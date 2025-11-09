function showPreview(input) {
      const preview = document.getElementById("imagePreview");
      const button = document.querySelector(".upload-btn");
      button.style.display = "none";

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          preview.src = e.target.result;
          preview.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        preview.src = "";
        preview.style.display = "none";
        button.style.display = "inline-block";
      }
    }