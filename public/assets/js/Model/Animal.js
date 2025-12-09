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
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-md-between mb-5 gap-2 gap-md-3">
            <p class="mb-0">${this.id}</p>
            <p class="mb-0">${this.name}</p>
            <p class="mb-0">${this.type}</p>
            <p class="mb-0">${this.gender}</p>
            <p class="mb-0">${this.status}</p>
            <a class="btn btn-sm" href="/animal/${this.id}">Voir</a>
        </div>
        `;
    }

    getAnimalInfoForVisitors() {}
}
