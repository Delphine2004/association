export class Animal {
    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.race = data.race;
        this.gender = data.gender;
        this.picture = data.picture;
        this.status = data.status;
        this.vaccinated = data.vaccinated;
        this.sterilized = data.sterilized;
        this.chipped = data.chipped;
        this.compatibleKid = data.compatibleKid;
        this.compatibleCat = data.compatibleCat;
        this.compatibleDog = data.compatibleDog;
        this.birthday = data.birthday;
        this.arrivalDate = data.arrivalDate;
    }

    getAnimalInfo() {
        return `
        <tr>
            <td>${this.id}</td>
            <td>${this.name}</td>
            <td>${this.type}</td>
            <td>${this.gender}</td>
            <td>${this.status}</td>
            <td>
                <a class="btn btn-sm" href="/animal/${this.id}">Voir</a>
            </td>
        </tr>
        `;
    }

    getAnimalCard() {
        return `
        <div class="col-12 col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <img src="${this.picture}" class="card-img-top" alt="${this.name}">
                <div class="card-body">
                    <h5 class="card-title">${this.name}</h5>
                    <p class="card-text">${this.type} • ${this.race}</p>
                    <a href="/animal/${this.id}" class="btn btn-sm">Voir</a>
                </div>
            </div>
        </div>
    `;
    }
}
