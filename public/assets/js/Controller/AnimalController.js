import { Animal } from "../Model/Animal.js";

export function showAnimalResult() {
    // Récupération des éléments
    const animalsList = document.getElementById("animals-list");
    const searchForm = document.getElementById("animal-search-form");

    if (!animalsList && !searchForm) return;

    const isAuthenticated = animalsList.dataset.isAuthenticated === "1";

    animalsList.innerHTML =
        '<p class="text-center">Merci de séléctionner des critéres de recherche.</p>';

    searchForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        // Récupération des valeurs
        const criteria = {
            id: document.getElementById("animal-id")?.value?.trim() || null,
            name: document.getElementById("name")?.value?.trim() || null,
            status: document.getElementById("status")?.value?.trim() || null,
            gender: document.getElementById("gender")?.value?.trim() || null,
            type: document.getElementById("type")?.value?.trim() || null,
            race: document.getElementById("race")?.value?.trim() || null,
            notVaccinated:
                document.getElementById("not-vaccinated")?.checked ?? null,
            notSterilized:
                document.getElementById("not-sterilized")?.checked ?? null,
            notChipped: document.getElementById("not-chipped")?.checked ?? null,
            compatibleKid:
                document.getElementById("compatible-kid")?.checked ?? null,
            compatibleCat:
                document.getElementById("compatible-cat")?.checked ?? null,
            compatibleDog:
                document.getElementById("compatible-dog")?.checked ?? null,
        };

        // Construction de la query string
        const params = new URLSearchParams();
        for (const key in criteria) {
            const value = criteria[key];
            if (
                value !== null &&
                value !== undefined &&
                value !== "" &&
                value !== false
            ) {
                params.append(key, value === true ? "1" : value);
            }
        }

        const url = "/animal/api?" + params.toString();

        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error("Erreur réseau : " + response.status);
            }

            const data = await response.json();

            if (data.status === "success") {
                animalsList.innerHTML = "";
                if (!data || data.count === 0) {
                    animalsList.innerHTML = `<p class="text-center">Aucun animal ne correspond à la recherche.</p>`;
                    searchForm.reset();
                } else if (isAuthenticated) {
                    data.animals.forEach((animalData) => {
                        const animal = new Animal(animalData);
                        animalsList.innerHTML += animal.getAnimalInfo();
                    });
                } else {
                    data.animals.forEach((animalData) => {
                        const animal = new Animal(animalData);
                        animalsList.innerHTML += animal.getAnimalCard();
                    });
                }
                searchForm.reset();
            }
        } catch (error) {
            animalsList.innerHTML =
                error ||
                `<p class="text-center">Une erreur est survenue lors de la recherche.</p>`;
        }
    });
}
