require('./app.js');

import CKEditor from '@ckeditor/ckeditor5-vue2';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import {MyCustomUploadAdapterPlugin} from './uploadAdapter';
import mapboxgl from 'mapbox-gl';

mapboxgl.accessToken = 'pk.eyJ1Ijoid2ludGVyc3VubmVyIiwiYSI6ImNrcGF1dGx2ZDBobWEydWxrOXl3bW10cTUifQ.a6OSkWg0Eg1yX76P847xwg';
mapboxgl.setRTLTextPlugin('https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-rtl-text/v0.2.0/mapbox-gl-rtl-text.js');
window.mapApiKey = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjEyMWQ3ZGI1YzE4YWUyZTM3MTM3NWEzNDZkZjI1NzQ5YTkxNWMzOGExZTVlOGRiZTVlNjdhNjI3ZjI2YjMxZjhmYzg3ZmJkNjE2NGZkZDQ0In0.eyJhdWQiOiIxNDE2OCIsImp0aSI6IjEyMWQ3ZGI1YzE4YWUyZTM3MTM3NWEzNDZkZjI1NzQ5YTkxNWMzOGExZTVlOGRiZTVlNjdhNjI3ZjI2YjMxZjhmYzg3ZmJkNjE2NGZkZDQ0IiwiaWF0IjoxNjIyMzU2OTY3LCJuYmYiOjE2MjIzNTY5NjcsImV4cCI6MTYyNDk0ODk2Nywic3ViIjoiIiwic2NvcGVzIjpbImJhc2ljIl19.J-OKO-kVRSnAqcMo8cUOPiegx5MZnlnz_1loDDapads6QqkQH2_2BrkptMkFGmLckW_uxCaMNvggTPOYvHO-bo-Ikri4FrKJrVkUq8XSJZ3Xq4v8OolMmktXcgWAfxuhLA2tKsPgh_tSTYp9Kb1rGhGiHawLVDvoAKCUuKABk8-wcgn_Byvq0NEBCOy9_MM9tm6aoGGRb7q6WbcKXJHZaT7VL-DeYl5Y0SZJwkjFGK7ahlFb7tzDp5LN2khbAy7-B6CcnqgKF4kLxaw_gJfgrwOfIFsCGbg352R1ALnaDPwPY9le6th31kuz-7TErJHxOM8mKQFVEoGYLRRfyb3new";
window.mapboxgl = mapboxgl;

import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

Vue.use(VuePersianDatetimePicker, {
    name: 'date-picker',
    props: {
        displayFormat: 'jYYYY/jMM/jDD HH:mm',
        format: 'YYYY-MM-DD HH:mm'
    }
});

CKEditor.component.props.editor.default = ClassicEditor;
CKEditor.component.props.config.default = () => {
    return {language: 'fa', extraPlugins: [MyCustomUploadAdapterPlugin]}
};
Vue.use(CKEditor);