import './bootstrap';
import scraperLink from "./scraperLink.js";

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', scraperLink.init);