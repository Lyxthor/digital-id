import html2canvas from 'html2canvas-pro'


document.getElementById('capture-btn').addEventListener('click', async ()=>{
    const content = document.getElementById('content')
    const form = document.getElementById('document-store-form');
    const filename = document.getElementById('filename');
    const membershipsContainer = document.getElementById('memberships-data')
    const memberships = JSON.parse(membershipsContainer.dataset.collection);

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
            console.log(memberships[2])

            Object.keys(memberships).forEach((i)=>{
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = `memberships[${i}][id]`;
                inputId.value = memberships[i].id;

                const inputRole = document.createElement('input');
                inputRole.type = 'hidden';
                inputRole.name = `memberships[${i}][role]`;
                inputRole.value = memberships[i].role;

                form.append(inputId)
                form.append(inputRole)
            })
            form.submit();
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }).catch(err => {
        console.error('Error capturing content:', err);
    });


})
