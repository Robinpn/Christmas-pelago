const form = document.querySelector('form');
const arrivalDate = document.querySelector('#arrival_date');
const departureDate = document.querySelector('#departure_date');
const totalAmount = document.querySelector('#total-amount');
let selectedRoom = document.querySelector('select');

const totalPrice = () => {
  let room = selectedRoom.options[selectedRoom.selectedIndex].text;

  let arrival = arrivalDate.value;
  let departure = departureDate.value;

  let amountOfDays = departure.split('-').pop() - arrival.split('-').pop();

  let roomCost;
  switch (room) {
    case 'budget':
      roomCost = 2;
      break;
    case 'standard':
      roomCost = 4;
      break;
    case 'luxury':
      roomCost = 8;
      break;
    default:
      roomCost = 0;
  }
  if (amountOfDays >= 1) {
    totalAmount.value = roomCost * amountOfDays + '$';
  } else {
    totalAmount.value = 0 + '$';
  }
};

form.addEventListener('change', () => {
  totalPrice();
});
