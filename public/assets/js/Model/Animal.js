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
        <div class="card p-3 mb-4 w-100">
            <div class="row justify-content-center align-items-center w-100 g-3">
                <div class="col-12 col-md-9">
                    <div class="d-flex flex-column flex-md-row justify-content-between">
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <p class="fw-bold mb-0">${this.name}</p>
                        </div>
                        <div class="d-flex flex-row justify-content-around gap-3">
                            <p class="mb-0">${this.type}</p>
                            <p class="mb-0">${this.gender}</p>
                        </div>
                        <div class="d-flex flex-column flex-md-row justify-content-between">
                            <p class="mb-0">${this.status}</p>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-2 text-center">
                    <a class="btn w-100" href="/animal/${this.id}">Voir</a>
                </div>
            </div>
        </div>
        `;
    }

    getAnimalCard() {
        return `
        <div class="col-12 col-md-6 mb-4">
            <div class="card h-100">
                <img src="${this.picture}" class="card-img-top" alt="${this.name}">
                <div class="card-body">
                    <h5>${this.name}</h5>
                    <p>${this.type} - ${this.race}</p>
                    <a href="/animal/${this.id}" class="btn btn-sm">Voir</a>
                </div>
            </div>
        </div>
    `;
    }
}
