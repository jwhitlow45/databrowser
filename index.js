const query_button = document.getElementById('query-button');
const insert_button = document.getElementById('insert-button');
const delete_button = document.getElementById('delete-button');
const resetdb_submit = document.getElementById('resetdb-button');
const query_form = document.getElementById('query-form');
const insert_form = document.getElementById('insert-form');
const query_submit = document.getElementById('query-submit');
const insert_submit = document.getElementById('insert-submit');

query_button.addEventListener('click', showQueryForm);
insert_button.addEventListener('click', showInsertForm);
query_submit.addEventListener('click', getData);
insert_submit.addEventListener('click', insertData);
resetdb_submit.addEventListener('click', resetDB);

let pokemon_arr = [];
let index = -1;

async function handleFetch(url, form) {
  let formData;
  if (form == null) {
    formData = new FormData();
  } else {
    formData = new FormData(form);
  }
  let result = await fetch(url, {
    method:'POST',
    body: formData
  }).then(response => {
    if (!response.ok)
      throw response.err;
    return response.json();
  }).catch(err => {
    console.log(err);
    return err;
  });
  return result;
}

function showQueryForm() {
  insert_form.hidden = 1;
  query_form.hidden = 0;
}

function showInsertForm() {
  insert_form.hidden = 0;
  query_form.hidden = 1;
}

async function resetDB() {
  await handleFetch('./php/cleardb.php', null);
}

async function insertData() {
  let result = await handleFetch('./php/insert.php', insert_form);
  console.log(result);
}

async function deleteData(number) {
  // build form to package number for post request
  const temp_form = document.createElement('form');
  const temp_input = document.createElement('input');
  temp_input.name = 'number';
  temp_input.value = number;
  temp_form.appendChild(temp_input);

  let result = await handleFetch('./php/delete.php', temp_form);
  console.log(result);
}

async function getData() {
  let result = await handleFetch('./php/query.php', query_form);
  console.log(result);
  return result;
}

async function populateDataBrowser() {
  pokemon_arr = await getData();
  index = 0;
}

function displayPokemon() {
  const image = document.getElementById('pokemon-image');
  let pokemon = pokemon_arr[index];
  image.src = './data/images/' + pokemon['number'] + '.png';

  for (let stat in pokemon) {
    if (pokemon[stat] !== '') {
      const cur_stat = document.getElementById(stat);
      if (stat == 'legendary') {
        cur_stat.innerText = pokemon[stat] === 1 ? 'true' : 'false';
        continue;
      }
      cur_stat.innerText = pokemon[stat];
    }
  }
}
