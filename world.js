document.addEventListener('DOMContentLoaded', () => {
  const lookupBtn = document.querySelector('#lookup');
  const lookupCitiesBtn = document.querySelector('#lookup-cities');
  const resultDiv = document.querySelector('#result');
  const countryInput = document.querySelector('#country');

  // COUNTRY LOOKUP
  lookupBtn.addEventListener('click', (e) => {
    e.preventDefault();

    const country = countryInput.value.trim();
    const url = `world.php?country=${encodeURIComponent(country)}`;

    fetch(url)
      .then(response => response.text())
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        console.error(error);
        resultDiv.innerHTML = '<p>There was an error fetching data.</p>';
      });
  });

  // CITY LOOKUP
  lookupCitiesBtn.addEventListener('click', (e) => {
    e.preventDefault();

    const country = countryInput.value.trim();
    const url = `world.php?country=${encodeURIComponent(country)}&lookup=cities`;

    fetch(url)
      .then(response => response.text())
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        console.error(error);
        resultDiv.innerHTML = '<p>There was an error fetching city data.</p>';
      });
  });

});
