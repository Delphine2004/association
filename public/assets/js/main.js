import { showAnimalResult } from "./Controller/AnimalController.js";
import { showEventResult } from "./Controller/EventController.js";
import {
    validateEmail,
    reloadEmailPage,
} from "./Controller/NewslettersController.js";

document.addEventListener("DOMContentLoaded", () => {
    showAnimalResult();
    showEventResult();
    validateEmail();
    reloadEmailPage();
});
