import './bootstrap';
import * as bootstrap from 'bootstrap';


import Alpine from 'alpinejs';
import { AdminCategories } from "./admin/categories";

window.Alpine = Alpine;
window.bootstrap = bootstrap;
Alpine.data('AdminCategories', AdminCategories);
Alpine.start();
