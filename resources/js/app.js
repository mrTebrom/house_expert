import './bootstrap';
import * as bootstrap from 'bootstrap';
// drag on drop
import Sortable from 'sortablejs';


import Alpine from 'alpinejs';
import { AdminCategories } from "./admin/categories";
import {gallerySortable} from "./admin/galery.js";
import {AdminDetailFields} from "./admin/detailsFiellds.js";

window.Alpine = Alpine;
window.bootstrap = bootstrap;
window.Sortable = Sortable;

Alpine.data('AdminCategories', AdminCategories);
Alpine.data('gallerySortable', gallerySortable);
Alpine.data('AdminDetailFields', AdminDetailFields);
Alpine.start();
