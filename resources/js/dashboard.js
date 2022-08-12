require('./bootstrap.js');

import CKEditor from '@ckeditor/ckeditor5-vue2';
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import Editor from 'ckeditor5-35.0.1-1yonwqufgwot/build/ckeditor'
import {MyCustomUploadAdapterPlugin} from './uploadAdapter';


import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

Vue.use(VuePersianDatetimePicker, {
    name: 'date-picker',
    props: {
        displayFormat: 'jYYYY/jMM/jDD HH:mm',
        format: 'YYYY-MM-DD HH:mm'
    }
});

CKEditor.component.props.editor.default = Editor.Editor;
CKEditor.component.props.config.default = () => {
    return {language: 'fa', extraPlugins: [MyCustomUploadAdapterPlugin], removePlugins: ['Title']}
};
Vue.use(CKEditor);

const app = new Vue({
    el: '#app',
});