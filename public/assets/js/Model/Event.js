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
        <tr>
            <td>${this.id}</td>
            <td>${this.date}</td>
            <td>${this.place}</td>
            <td>
                <a class="btn btn-sm" href="/event/${this.id}">Voir</a>
            </td>
        </tr>
    `;
    }
}
