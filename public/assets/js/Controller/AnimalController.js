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
            notVaccinated:
                document.getElementById("not-vaccinated")?.checked ?? null,
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
                if (data.count === 0) {
                    animalsList.innerHTML = `<p class="text-center">Aucun animal ne correspond à la recherche.</p>`;
                    searchForm.reset();
                }

                if (isAuthenticated) {
                    animalsList.innerHTML = `
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="table-responsive shadow-sm border rounded">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nom</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Genre</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="animals-table-body"></tbody>
                            </table>
                      </div>
                    </div>
            `;

                    const tableBody =
                        document.getElementById("animals-table-body");

                    tableBody.innerHTML = data.animals
                        .map((animalData) => {
                            const animal = new Animal(animalData);
                            return animal.getAnimalInfo();
                        })
                        .join("");
                } else {
                    /* ===============================
           VISITEUR → CARTES
           =============================== */
                    animalsList.classList.add("row");

                    animalsList.innerHTML = data.animals
                        .map((animalData) => {
                            const animal = new Animal(animalData);
                            return animal.getAnimalCard();
                        })
                        .join("");
                }
                searchForm.reset();
            }
        } catch (error) {
            animalsList.innerHTML = `<p class="text-center">Une erreur est survenue lors de la recherche.</p>`;
        }
    });
}
