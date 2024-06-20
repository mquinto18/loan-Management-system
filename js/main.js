const addPaymentButtons = document.querySelectorAll('.addpayBtn');
const paymentElement = document.getElementById('yourPaymentElementId'); // Replace with the actual ID of your payment element

// Iterate over each add payment button and add a click event listener
addPaymentButtons.forEach(button => {
    button.addEventListener('click', function() {
        // Toggle the display style between 'none' and 'flex'
        paymentElement.style.display = (paymentElement.style.display === 'none' || paymentElement.style.display === '') ? 'flex' : 'none';
    });
});