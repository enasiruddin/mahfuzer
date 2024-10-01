const switches = document.querySelectorAll('.switch input');

function fetchSwitchStates() {
    fetch('api.php')
        .then(response => response.json())
        .then(data => {
            switches.forEach((input, index) => {
                input.checked = data[index] === 1;
            });
        })
        .catch(error => console.error('Error fetching switch states:', error));
}

// Function to update individual switch state
function updateSwitchState(switchNumber, state) {
    fetch('api.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ switch_number: switchNumber, state: state }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message || data.error);
    })
    .catch(error => console.error('Error updating switch state:', error));
}

// Add event listeners to each switch
switches.forEach((input, index) => {
    input.addEventListener('change', () => {
        const state = input.checked ? 1 : 0;
        updateSwitchState(index, state);
    });
});

// Fetch initial switch states on page load
fetchSwitchStates();
