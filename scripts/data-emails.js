// Connexion à la base de données
let db = db.getSiblingDB("association");

db.newsletter.insertMany([
    {
        email: "email_1@email.com",
        agreement: true,
    },
    {
        email: "email_15@email.com",
        agreement: true,
    },
    {
        email: "email_29@email.com",
        agreement: true,
    },
    {
        email: "email_99@email.com",
        agreement: true,
    },
    {
        email: "email_47@email.com",
        agreement: true,
    },
    {
        email: "email_39@email.com",
        agreement: true,
    },
]);
