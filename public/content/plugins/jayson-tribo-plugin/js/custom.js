// Validate name and email fields
function validateForm() {
    const nameEl = document.forms["newsletter-form"]["name"];
    const emailEl = document.forms["newsletter-form"]["email"];
    let hasError = false;

    let name = nameEl.value;
    let email = emailEl.value;

    // Remove error messages
    document.querySelectorAll(".text-error").forEach(el => el.remove());
    document.querySelectorAll(".text-success").forEach(el => el.remove());

    if (name == "") {
      const nameErrEl = document.createElement('div');
      nameErrEl.setAttribute('class', 'text-error error-name');
      nameErrEl.innerHTML = "Name is required!";

      nameEl.after(nameErrEl);

      hasError = true;
    }

    if (email == "") {
        const emailErrEl = document.createElement('div');
        emailErrEl.setAttribute('class', 'text-error error-email');
        emailErrEl.innerHTML = "Email is required!";

        emailEl.after(emailErrEl);

        hasError = true;
    }

    if (!hasError){
        document.getElementsByClassName('newsletter-button')[0].setAttribute('disabled', true);
        saveData(name, email);
    }

    return false;
}

// Save data to database
function saveData(name, email) {
    const data = { 
        name : name,
        email : email
    }
    const url = location.protocol + '//' + location.host + "?rest_route=/newsletter/v1/save/";

    fetch(url, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(response => {
        const buttonEl = document.getElementsByClassName('newsletter-button')[0];
        const formErrEl = document.createElement('div');
        formErrEl.innerHTML = response['message'];

        if(response['status'] === "success") {
            formErrEl.setAttribute('class', 'text-success');
        } else {
            formErrEl.setAttribute('class', 'text-error error-form');
            document.getElementsByClassName('newsletter-button')[0].setAttribute('disabled', false);
        }

        buttonEl.after(formErrEl);

        setTimeout(function(){
            document.getElementsByClassName('newsletter-modal')[0].classList.add('hidden');
        }, 1000);
    })

    return false;
}