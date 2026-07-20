
function initFormValidation(url, idForm) {
    const form = document.getElementById(idForm);
    if (!form) return; 

    function validateField(targetElement) {
        const formData = new FormData(form);

        fetch(url, {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest" 
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            const fieldName = targetElement.name;
            const errorElement = document.getElementById(`${fieldName}_error`);
            
            if (errorElement) {
                errorElement.innerHTML = data.errors?.[fieldName] || "";
            }
        })
        .catch(error => console.error("Erreur de validation:", error));
    }

    const inputs = form.querySelectorAll("input, select, textarea");
    
    inputs.forEach(el => {
        const eventType = (el.tagName === "SELECT" || el.type === "checkbox" || el.type === "radio") ? "change" : "input";
        
        el.addEventListener(eventType, () => {
            validateField(el);
        });
    });
}

