export class Event {
    constructor(data) {
        this.id = data.id;
        this.date = data.date;
        this.place = data.place;
        this.description = data.description;
        this.picture = data.picture;
    }

    getEventInfo() {
        return `
        <div class="card p-3 mb-4 w-100">
            <div class="row justify-content-center align-items-center w-100 g-3">
                <div class="col-12 col-md-9">
                    <p class="fw-bold">${this.date}</p>
                    <p>${this.place}</p>
                </div>
                <div class="col-12 col-md-2 text-center">
                    <a class="btn w-100" href="/event/${this.id}">Voir</a>
                </div>
            </div>
        </div>
    `;
    }
}
