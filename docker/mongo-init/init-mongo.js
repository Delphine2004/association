// Créer un utilisateur admin
db.getSiblingDB("admin").createUser({
    user: "admin",
    pwd: "adminpassword",
    roles: [{ role: "root", db: "admin" }],
});

// Créer un utilisateur spécifique
db.getSiblingDB("association").createUser({
    user: "association_user",
    pwd: "association25",
    roles: [{ role: "readWrite", db: "association" }],
});
