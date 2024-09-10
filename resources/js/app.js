import './bootstrap';
import scraperLink from "./scraperLink.js";
import syncLink from './syncLink.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
if(document.querySelector("#run-scraper-link")){
    document.addEventListener('DOMContentLoaded', scraperLink.init);
    document.addEventListener('DOMContentLoaded', syncLink.init);
}