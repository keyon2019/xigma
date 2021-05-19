class MyUploadAdapter {
    constructor(loader) {
        this.loader = loader;
        this.formData = new FormData();
        this.config = {
            onUploadProgress: (progressEvent) => {
                this.loader.uploaded = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                this.loader.uploadTotal = progressEvent.total;
            }
        }
    }

    upload() {
        return this.loader.file.then(file => new Promise((resolve, reject) => {
            this.formData.append('file', file);
            axios.post('/dashboard/picture', this.formData, this.config).then((response) => {
                return resolve({default: response.data.url});
            }).catch((e) => {
                return reject(e.response.data.error)
            });
        }));
    }
}

export function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    }
}