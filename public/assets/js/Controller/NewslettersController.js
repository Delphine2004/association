export function validateEmail() {
    // Récupération des éléments

    const letterForm = document.getElementById("letter-form");
    const emailInput = document.getElementById("newsletter_email");
    const agreementCheckbox = document.getElementById("agreement");
    const feedback = document.getElementById("feedback");
    const submitBtn = document.getElementById("letter-btn");

    if (
        !letterForm ||
        !emailInput ||
        !agreementCheckbox ||
        !submitBtn ||
        !feedback
    )
        return;

    submitBtn.disabled = false;

    letterForm.addEventListener("submit", async (event) => {
        event.preventDefault();
        feedback.innerHTML = "";

        const email = emailInput.value.trim();
        const agreement = agreementCheckbox.checked;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailRegex.test(email)) {
            feedback.innerHTML = "L'email n'est pas au bon format.";
            return;
        }

        if (!agreement) {
            feedback.innerHTML = `<p class="text-center">Vous devez confirmer votre inscription.</p>`;
            return;
        }

        submitBtn.disabled = true;

        const url = "/home/api";

        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ email, agreement }),
            });

            const data = await response.json();

            if (data.success) {
                feedback.innerHTML = `<p class="text-center">Vous êtes bien inscrit(e)</p>`;
                letterForm.reset();
            } else {
                feedback.innerHTML = `<p class="text-center">${data.message ?? "Email déjà inscrit."}</p>`;
            }
        } catch (error) {
            feedback.innerHTML =
                error ||
                `<p class="text-danger text-center">Une erreur est survenue.</p>`;
        } finally {
            submitBtn.disabled = false;
        }
    });
}
