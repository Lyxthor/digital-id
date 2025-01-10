import html2canvas from 'html2canvas-pro'


document.getElementById('capture-btn').addEventListener('click', ()=>{
    const content = document.getElementById('content')
    const form = document.getElementById('document-store-form');
    const filename = document.getElementById('filename');
    let formData = new FormData();
    html2canvas(content).then(canvas => {
        const imageDataURL = canvas.toDataURL('image/png');
        formData.append('image', imageDataURL)
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'))

        fetch('/image',
        {
            method: 'POST',
            enctype: 'multipart/form-data',
            body: formData,  // Send the FormData as the body of the request
        })
        .then(response => response.json())  // Assuming server responds with JSON
        .then(data => {
            filename.setAttribute('value', data.filename);
            form.submit();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }).catch(err => {
        console.error('Error capturing content:', err);
    });

    
})
