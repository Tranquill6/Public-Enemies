import $ from 'jquery';
window.$ = window.jQuery = $;

import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import DataTable from 'datatables.net-dt';

import { initFlowbite } from 'flowbite';
import 'flowbite/dist/datepicker';
initFlowbite();

import 'flowbite-datepicker';
import 'flowbite-datepicker/Datepicker';