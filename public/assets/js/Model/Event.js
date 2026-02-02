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
        <div class="card border-brown rounded-4 p-3 mb-4 w-100">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-0">
                <p class="card-text mb-0 text-md-start text-center">${this.date} - ${this.place}</p>
                <a class="btn btn-sm" href="/event/${this.id}">Voir</a>
            </div>
        </div>
    `;
    }
}
