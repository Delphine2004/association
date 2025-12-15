import { Event } from "../Model/Event.js";

export function showEventResult() {
    // Récupération des éléments
    const eventsList = document.getElementById("events-list");
    const searchForm = document.getElementById("event-search-form");

    if (!eventsList && !searchForm) return;

    eventsList.innerHTML =
        '<p class="text-center">Merci de séléctionner des critéres de recherche.</p>';

    searchForm.addEventListener("submit", async function (event) {
        event.preventDefault();

        // Récupération des valeurs
        const criteria = {
            id: document.getElementById("event-id")?.value?.trim() || null,
            date: document.getElementById("date")?.value?.trim() || null,
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

        const url = "/event/api?" + params.toString();

        try {
            const response = await fetch(url);

            if (!response.ok) {
                throw new Error("Erreur réseau : " + response.status);
            }

            const data = await response.json();

            if (data.status === "success") {
                eventsList.innerHTML = "";
                if (data.count === 0) {
                    eventsList.innerHTML = `<p class="text-center">Aucun événement ne correspond à la recherche.</p>`;
                    searchForm.reset();
                } else {
                    eventsList.innerHTML = `
                    <div class="col-12 col-md-10 col-lg-8">
                        <div class="table-responsive shadow-sm border rounded">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Lieu</th>
                                        <th scope="col" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="events-table-body"></tbody>
                            </table>
                        </div>
                    </div>
                    `;

                    const tableBody =
                        document.getElementById("events-table-body");

                    data.events.forEach((eventData) => {
                        const event = new Event(eventData);
                        tableBody.innerHTML += event.getEventInfo();
                    });
                    searchForm.reset();
                }
            }
        } catch (error) {
            eventsList.innerHTML = `<p class="text-center">Une erreur est survenue lors de la recherche.</p>`;
        }
    });
}
