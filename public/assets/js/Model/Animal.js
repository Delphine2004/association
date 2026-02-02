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
        <div class="card border-brown rounded-4 p-3 mb-4 w-100">
            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 p-0">
                <p class="card-text mb-0 text-md-start text-center">${this.name} - ${this.type} - ${this.gender} - ${this.status}</p>
                <a class="btn btn-sm" href="/animal/${this.id}">Voir</a>
            </div>
        </div>
        `;
    }

    getAnimalCard() {
        return `
        <div class="col-12 col-md-6 mb-4">
            <div class="card h-100">
                <img src="${this.picture}" class="card-img-top" alt="${this.name}">
                <div class="card-body bg-light-pink text-brown">
                    <h5 class="card-title">${this.name}</h5>
                    <p class="card-text">${this.type} - ${this.race}</p>
                    <a href="/animal/${this.id}" class="btn btn-sm">Voir</a>
                </div>
            </div>
        </div>
    `;
    }
}
