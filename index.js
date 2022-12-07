const query_button = document.getElementById('query-button');
const insert_button = document.getElementById('insert-button');
const resetdb_submit = document.getElementById('resetdb-button');
const query_form = document.getElementById('query-form');
const query_table = document.getElementById('query-table');
const insert_form = document.getElementById('insert-form');
const query_submit = document.getElementById('query-submit');
const insert_submit = document.getElementById('insert-submit');
const edit_stats_form = document.getElementById('edit-stats-form');

query_button.addEventListener('click', showQueryForm);
insert_button.addEventListener('click', showInsertForm);
query_submit.addEventListener('click', getData);
insert_submit.addEventListener('click', insertData);
resetdb_submit.addEventListener('click', resetDB);

const sort_name_button = document.getElementById('sort-name-button');
const sort_number_button = document.getElementById('sort-number-button');
const start_button = document.getElementById('start-button');
const prev_button = document.getElementById('prev-button');
const delete_button = document.getElementById('delete-button');
const next_button = document.getElementById('next-button');
const end_button = document.getElementById('end-button');
const edit_toggle_button = document.getElementById('edit-toggle-button');

sort_name_button.addEventListener('click', sortByName);
sort_number_button.addEventListener('click', sortByNumber);
start_button.addEventListener('click', dbScrollStart);
prev_button.addEventListener('click', function(){ dbScroll(-1)});
delete_button.addEventListener('click', dbDelete);
next_button.addEventListener('click', function (){ dbScroll(1)});
end_button.addEventListener('click', dbScrollEnd);
edit_toggle_button.addEventListener('click', toggleEdit);

const edit_submit = document.getElementById('edit-submit');
edit_submit.addEventListener('click', editData);


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
  insert_form.setAttribute('hidden', 'hidden');
  query_table.removeAttribute('hidden');
}

function showInsertForm() {
  query_table.setAttribute('hidden', 'hidden');
  insert_form.removeAttribute('hidden');
}

async function resetDB() {
  let isConfirmed = confirm('Are you sure you want to reset the database?\nThis cannot be undone.');
  if (!isConfirmed) return;
  await handleFetch('./php/cleardb.php', null);
  window.location.reload();
}

async function insertData() {
  let result = await handleFetch('./php/insert.php', insert_form);
  console.log(result);
  alert(result);
}

async function editData() {
  if (pokemon_arr.length < 1) {
    alert('Cannot edit null entry!');
    return;
  }
  // set form number so we can tell the server which pokemon number needs to be updated
  const edit_form_number = document.getElementById('edit-form-number');
  edit_form_number.value = pokemon_arr[index]['number'];

  let result = await handleFetch('./php/edit.php', edit_stats_form);

  // update current pokemon's data, but ensure it is still part of the query criteria
  let temp_index = index;
  console.log(temp_index);
  await getData();
  if (temp_index >= pokemon_arr.length)
    temp_index--;
  index = temp_index;
  console.log(index);
  displayPokemon();
  alert(result);
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
  pokemon_arr = await handleFetch('./php/query.php', query_form);
  if (pokemon_arr.length > 0) {
    index = 0;
    displayPokemon();
  } else {
    setDBImage('./data/images/placeholder.png');
    index = -1;
  } 
  console.log(pokemon_arr);
}

function displayPokemon() {
  if (pokemon_arr.length < 1) {
    setDBImage('./data/images/placeholder.png');
    const stat_values = document.getElementsByClassName('stat');
    for (let value of stat_values)
      value.innerText = '???';
    displayIndex(true);
    return;
  }

  let pokemon = pokemon_arr[index];
  let number = pokemon['number'];
  let path;
  if (number > 721) { // image in user_images
    path = './data/user_images/' + number + '.png'
  } else {
    path = './data/images/' + number + '.png'
  }
  setDBImage(path);
  displayIndex();

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

function displayIndex(empty=false) {
  const display_index = document.getElementById('display-index');

  if (empty) {
    display_index.innerText = '???';
    return;
  }
  display_index.innerText = (index + 1) + '/' + pokemon_arr.length;
}

function setDBImage(path) {
  const image = document.getElementById('pokemon-image');
  image.src = path;
}

function dbScroll(direction) {
  if (pokemon_arr.length < 1) return;
  index = (index + direction + pokemon_arr.length) % pokemon_arr.length;
  displayPokemon();
}

function dbScrollStart() {
  if (pokemon_arr.length < 1) return;
  index = 0;
  displayPokemon();
}

function dbScrollEnd() {
  if (pokemon_arr.length < 1) return;
  index = pokemon_arr.length - 1;
  displayPokemon();
}

function dbDelete() {
  if (pokemon_arr.length < 1) return;
  let number = pokemon_arr[index]['number']
  // delete from database
  deleteData(number);
  // delete from local representation of database
  pokemon_arr.splice(index, 1);
  if (index >= pokemon_arr.length)
    index--;
  displayPokemon();
}

function sortByName() {
  function compareName(a, b) {
    if (a['name'] < b['name'])
      return -1;
    if (a['name'] > b['name'])
      return 1;
    return 0;
  }

  pokemon_arr = pokemon_arr.sort(compareName);
  index = 0;
  displayPokemon();
}

function sortByNumber() {
  function compareNumber(a, b) {
    if (a['number'] < b['number'])
      return -1;
    if (a['number'] > b['number'])
      return 1;
    return 0;
  }

  pokemon_arr = pokemon_arr.sort(compareNumber);
  index = 0;
  displayPokemon();
}

function toggleEdit() {
  if (edit_stats_form.hasAttribute('hidden')) {
    edit_stats_form.removeAttribute('hidden');
  } else {
    edit_stats_form.setAttribute('hidden', 'hidden');
  }
}


