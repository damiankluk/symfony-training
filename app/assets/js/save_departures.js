document.querySelectorAll('.add-button').forEach(button => {
    button.addEventListener('click', async (event) => {
        const row = event.target.parentNode.parentNode;
        const line = row.querySelector('td:nth-child(1)').textContent;
        const destination = row.querySelector('td:nth-child(2)').textContent;
        const time = row.querySelector('td:nth-child(3)').textContent;
        const stop = row.getAttribute('data-stop');
        const data = { line, destination, time };

        const response = await fetch('/save-departures', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            const responseData = await response.json();
            console.log('Success:', responseData);
        } else {
            console.error('Error:', response.statusText);
        }
    });
});