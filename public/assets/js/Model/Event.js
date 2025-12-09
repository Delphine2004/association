export class Event {
    constructor(data) {
        this.id = data.id;
        this.date = data.date;
        this.place = data.place;
        this.description = data.description;
        this.picture = data.picture;
        console.log(this.date);
    }

    getEventInfo() {
        return `
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between mb-5 gap-2 gap-md-3">
            <p class="mb-0">${this.id}</p>
            <p class="mb-0">${this.date}</p>
            <p class="mb-0">${this.place}</p>
            <a class="btn btn-sm" href="/event/${this.id}">Voir</a>
        </div>`;
    }
}
