/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
window.UIkit = UIkit;
UIkit.use(Icons);

window.Event = new Vue();

import {Loading} from './loading';
import {Form} from './form';
import {Modal} from './modal';

window.Loading = new Loading();
window.Form = Form;
window.Modal = Modal;

const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));


const user = JSON.parse(document.querySelector('meta[name="user"]').getAttribute('content'));
if (!_.isEmpty(user))
    Vue.prototype.user = user;