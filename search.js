

function handleSubmit() {
    const roomSelect = document.getElementById('roomSelect');
    const dateInput = document.getElementById('date_in');
    let selectedRoom = roomSelect.value;
    let selectedDate = dateInput.value;

    // Log the selected room and date
    console.log('Selected Room:', selectedRoom);
    console.log('Selected Date:', selectedDate);

    // You can store these values in variables or use them as needed
    let timestamp = selectedDate;
    let chosenRoom = selectedRoom;

    // Example of using the variables
    let fTimeStamp = timestamp.replace("T", " ");
    console.log('Timestamp:', fTimeStamp);
    console.log('Chosen Room:', chosenRoom);
    alert(`http://localhost/site/get_rooms.php?search_metrics&room=${selectedRoom}&timestamp=${encodeURI(fTimeStamp)}`)
    fetch(`http://localhost/site/get_rooms.php?search_metrics&room=${selectedRoom}&timestamp=${encodeURI(fTimeStamp)}`)
    .then(response => response.json())
    .then(data => {
       
     
        
        console.log(data);
    });
}




// Call the function to populate room options when the page loads
window.onload = populateRoomOptions;

