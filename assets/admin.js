import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

const textArea = document.querySelector('textarea[name="post[content]"]')

class MyUploadAdapter {
  /**
   * @param {import('@ckeditor/ckeditor5-upload').FileLoader} loader
   */
  constructor(loader) {
    this.loader = loader
  }

  upload() {
    return this.loader.file
      .then(file => new Promise((resolve, reject) => {
        if (!file) {
          return
        }

        const error = `Couldn't upload file: ${file.name}.`
        const xhr = this.xhr = new XMLHttpRequest()

        xhr.open('POST', '/post/upload', true)
        xhr.responseType = 'json'

        xhr.addEventListener('error', (e) => reject(error))
        xhr.addEventListener('abort', () => reject())
        xhr.addEventListener('load', () => {
          resolve({
            default: xhr.response.data
          })
        })

        xhr.upload.addEventListener('progress', evt => {
          if (evt.lengthComputable) {
            this.loader.uploadTotal = evt.total
            this.loader.uploaded = evt.loaded
          }
        })

        const data = new FormData()
        data.append('upload[image]', file)
        xhr.send(data)
      }))
  }

  abort() {
    if (this.xhr) {
      this.xhr.abort()
    }
  }
}

if (textArea) {
  ClassicEditor.create(textArea)
    .then(editor => {
      editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader)
      }
    })
    .catch(e => console.log(e))
}
